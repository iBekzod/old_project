<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Controllers\Api;

use App\BusinessSetting;
use App\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use App\User;
use App\Notifications\EmailVerificationNotification;
use Napa\R19\Sms;
use Illuminate\Support\Facades\DB;
use App\Seller;
use App\Shop;
use Illuminate\Support\Facades\Hash;
use \Cviebrock\EloquentSluggable\Services\SlugService;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6'
        ]);
        $user = new User([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password)
        ]);

        if(BusinessSetting::where('type', 'email_verification')->first()->value != 1){
            $user->email_verified_at = date('Y-m-d H:m:s');
        }
        else {
            // TODO Check for maintenance
        //            $user->notify(new EmailVerificationNotification());
        }
        $user->save();

        $customer = new Customer;
        $customer->user_id = $user->id;
        $customer->save();
        return response()->json([
            'message' => 'Registration Successful. Please verify and log in to your account.'
        ], 201);
    }

    public function signinByPhoneNumber(Request $request)
    {
        $request->validate([
            'phone' => 'required|min:6|numeric',
            'verification_code' => 'required|digits:4',
        ]);

        $phone_verified = DB::table('phone_verifications')
            ->where('phone', '=', $request->phone)
        //            ->where('verification_code', '=', $request->verification_code)
            ->orderBy('id', 'desc')
            ->first();

        if($phone_verified){
            if($phone_verified->verification_code == $request->get('verification_code'))
            {
                if($user=User::where('phone', '=', $request->phone)->first()){
                    $tokenResult = $user->createToken('Personal Access Token');
                    return $this->loginSuccess($tokenResult, $user);
                }else{
                    $user = new User([
                        'phone' => $request->phone,
                        'verification_code' => $request->verification_code
                    ]);
                    if(BusinessSetting::where('type', 'email_verification')->first()->value != 1){
                        $user->email_verified_at = date('Y-m-d H:m:s');
                    }
                    $user->save();

                    $customer = new Customer;
                    $customer->user_id = $user->id;
                    $customer->save();

                    $tokenResult = $user->createToken('Personal Access Token');
                    return $this->loginSuccess($tokenResult, $user);
                }
            }else{
                return response()->json([
                    'message' => 'Not verified',
                    'user'=>NULL
                ], 401);
            }

        }else{
            return response()->json([
                'message' => 'Not verified',
                'user'=>NULL
            ], 401);
        }


    }

    public function registerPhoneNumber(Request $request){
        // dd($request->phone);
        $request->validate([
            'phone' => 'required|min:6'
        ]);

        $verification_code=$this->generateRandomOtp();

        // dd($verification_code);

        if(auth()->check()){
            DB::table('phone_verifications')->updateOrInsert(
                [
                    'phone' => $request->phone,
                ],
                [
                'user_id'=>auth()->id(),
                'phone' => $request->phone,
                'verification_code' => $verification_code,
                'created_at' => now()
            ]);
        }else{
            DB::table('phone_verifications')->updateOrInsert([
                'phone' => $request->phone,
                'verification_code' => $verification_code,
                'created_at' => now()
            ]);
        }
        try {
            $sms_response = Sms::send($request->phone, 'Your ashop.uz verification code '.$verification_code);
        } catch (\Exception $th) {
            //throw $th;
        }


        return response()->json([
        //            'verification_code' => $verification_code,
        //            'sms_response'=>$sms_response['message']
        ], 200);
    }

    private function generateRandomOtp(){
        return rand(1000, 9999);
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);
        $credentials = request(['email', 'password']);
        if (!Auth::attempt($credentials))
            return response()->json(['message' => 'Unauthorized', 'user' => null], 401);

        $user = $request->user();
        if($user->email_verified_at == null){
            return response()->json(['message' => 'Please verify your account', 'user' => null], 401);
        }
        $tokenResult = $user->createToken('Personal Access Token');
        return $this->loginSuccess($tokenResult, $user);
    }

    public function user(Request $request)
    {
        return response()->json($request->user('api'));
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }

    public function socialLogin(Request $request)
    {
        $request->validate([
            'email' => 'required|string|email'
        ]);
        if (User::where('email', $request->email)->first() != null) {
            $user = User::where('email', $request->email)->first();
        } else {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email,
                'provider_id' => $request->provider,
                'email_verified_at' => Carbon::now()
            ]);
            $user->save();
            $customer = new Customer;
            $customer->user_id = $user->id;
            $customer->save();
        }
        $tokenResult = $user->createToken('Personal Access Token');
        return $this->loginSuccess($tokenResult, $user);
    }

    protected function loginSuccess($tokenResult, $user)
    {
        $token = $tokenResult->token;
        $token->expires_at = Carbon::now()->addWeeks(100);
        $token->save();
        return response()->json([
            'url'=>route('dashboard'),
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => $user
        ]);
    }


    public function registerSeller(Request $request)
    {
        $request->validate([
            'email' => 'required|unique:users|max:255',
            'name' => 'required',
            'surname' => 'required',
            'shop_name' => 'required',
            'phone' => 'required|unique:users',
            'terms' => 'required',
            'password' => 'required'
        ]);
        $user = new User;
        $user->name = $request->name;
        $user->name = $request->name.' '.$request->surname;
        $user->email = $request->email;
        $user->user_type = "seller";
        $user->email_verified_at = now();
        $user->password = Hash::make($request->password);
        if($user->save()){
            $seller = new Seller;
            $seller->user_id = $user->id;
            if($seller->save()){
                $shop = new Shop;
                $shop->user_id = $user->id;
                $shop->name = $request->shop_name;
                $shop->meta_title = $request->shop_name;
                $shop->slug =SlugService::createSlug(Shop::class, 'slug', slugify($request->shop_name));
                $shop->save();
                // $user->id=encrypt($user->id);
                // auth()->login($user, true);
                $tokenResult = $user->createToken('Personal Access Token');
                return $this->loginSuccess($tokenResult, $user);
            }
        }
        return response()->json([
            'message' => 'Not verified',
            'user'=>NULL
        ], 401);
    }

    public function loginSeller($id)
    {
        $seller = Seller::findOrFail($id);
        // $seller = Seller::findOrFail(decrypt($id));
        $user  = $seller->user;
        auth()->login($user, true);
        return response()->json([
            'message' => 'Not verified',
            'url'=>route('dashboard')
        ], 200);
    }
}
