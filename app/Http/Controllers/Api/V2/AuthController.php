<?php /** @noinspection PhpUndefinedClassInspection */

namespace App\Http\Controllers\Api\V2;

use App\Http\Controllers\OTPVerificationController;
use App\Models\BusinessSetting;
use App\Models\Customer;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\User;
use App\Notifications\AppEmailVerificationNotification;
use Hash;


class AuthController extends Controller
{
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

    public function signup(Request $request)
    {
        if (User::where('email', $request->email_or_phone)->orWhere('phone', $request->email_or_phone)->first() != null) {
            return response()->json([
                'result' => false,
                'message' => 'User already exists.',
                'user_id' => 0
            ], 201);
        }

        if ($request->register_by == 'email') {
            $user = new User([
                'name' => $request->name,
                'email' => $request->email_or_phone,
                'password' => bcrypt($request->password),
                'verification_code' => rand(100000, 999999)
            ]);
        } else {
            $user = new User([
                'name' => $request->name,
                'phone' => $request->email_or_phone,
                'password' => bcrypt($request->password),
                'verification_code' => rand(100000, 999999)
            ]);
        }

        if (BusinessSetting::where('type', 'email_verification')->first()->value != 1) {
            $user->email_verified_at = date('Y-m-d H:m:s');
        } elseif ($request->register_by == 'email') {
            $user->notify(new AppEmailVerificationNotification());
        } else {
            $otpController = new OTPVerificationController();
            $otpController->send_code($user);
        }

        $user->save();

        $customer = new Customer;
        $customer->user_id = $user->id;
        $customer->save();
        return response()->json([
            'result' => true,
            'message' => 'Registration Successful. Please verify and log in to your account.',
            'user_id' => $user->id
        ], 201);
    }

    public function resendCode(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();
        $user->verification_code = rand(100000, 999999);

        if ($request->verify_by == 'email') {
            $user->notify(new AppEmailVerificationNotification());
        } else {
            $otpController = new OTPVerificationController();
            $otpController->send_code($user);
        }

        $user->save();

        return response()->json([
            'result' => true,
            'message' => 'Verification code is sent again',
        ], 200);
    }

    public function confirmCode(Request $request)
    {
        $user = User::where('id', $request->user_id)->first();

        if ($user->verification_code == $request->verification_code) {
            $user->email_verified_at = date('Y-m-d H:i:s');
            $user->verification_code = null;
            $user->save();
            return response()->json([
                'result' => true,
                'message' => 'Your account is now verified.Please login',
            ], 200);
        } else {
            return response()->json([
                'result' => false,
                'message' => 'Code does not match, you can request for resending the code',
            ], 200);
        }
    }

    public function login(Request $request)
    {
        /*$request->validate([
            'email' => 'required|string|email',
            'password' => 'required|string',
            'remember_me' => 'boolean'
        ]);*/

        $delivery_boy_condition = $request->has('user_type') && $request->user_type == 'delivery_boy';

        if ($delivery_boy_condition) {
            $user = User::whereIn('user_type', ['delivery_boy'])->where('email', $request->email)->orWhere('phone', $request->email)->first();
        } else {
            $user = User::whereIn('user_type', ['customer', 'seller'])->where('email', $request->email)->orWhere('phone', $request->email)->first();
        }

        if (!$delivery_boy_condition) {
            if (\App\Utility\PayhereUtility::create_wallet_reference($request->identity_matrix) == false) {
                return response()->json(['result' => false, 'message' => 'Identity matrix error', 'user' => null], 401);
            }
        }


        if ($user != null) {
            if (Hash::check($request->password, $user->password)) {

                if ($user->email_verified_at == null) {
                    return response()->json(['message' => 'Please verify your account', 'user' => null], 401);
                }
                $tokenResult = $user->createToken('Personal Access Token');
                return $this->loginSuccess($tokenResult, $user);


            } else {
                return response()->json(['result' => false, 'message' => 'Unauthorized', 'user' => null], 401);
            }
        } else {
            return response()->json(['result' => false, 'message' => 'User not found', 'user' => null], 401);
        }

    }

    public function user(Request $request)
    {
        return response()->json($request->user());
    }

    public function logout(Request $request)
    {
        $request->user()->token()->revoke();
        return response()->json([
            'result' => true,
            'message' => 'Successfully logged out'
        ]);
    }

    public function socialLogin(Request $request)
    {
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
            'result' => true,
            'message' => 'Successfully logged in',
            'access_token' => $tokenResult->accessToken,
            'token_type' => 'Bearer',
            'expires_at' => Carbon::parse(
                $tokenResult->token->expires_at
            )->toDateTimeString(),
            'user' => [
                'id' => $user->id,
                'type' => $user->user_type,
                'name' => $user->name,
                'email' => $user->email,
                'avatar' => $user->avatar,
                'avatar_original' => api_asset($user->avatar_original),
                'phone' => $user->phone
            ]
        ]);
    }


}
