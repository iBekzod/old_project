<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\UserCollection;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Image;
use App\Http\Controllers\Controller;

class UserController extends Controller
{
    public function info($id)
    {
        return new UserCollection(User::where('id', $id)->get());
    }

    public function updateName(Request $request)
    {
        $user = User::findOrFail($request->user_id);
        $user->update([
            'name' => $request->name
        ]);
        return response()->json([
            'message' => 'Profile information has been updated successfully'
        ]);
    }

    public function updateUser(Request $request)
    {
        $request->validate([
            'user_id' => 'required'
        ]);

        $user = User::findOrFail($request->user_id);

        $changed = [];

        if ($request->has('name') && $request->name) {
            $user->update([
                'name' => $request->name
            ]);
            $changed[] = 'name';
        }

        if ($request->has('email') && $request->email) {
            $user->update([
                'email' => $request->email
            ]);
            $changed[] = 'email';
        }

//        if($request->has('avatar') && $request->avatar){
//            $user->update([
//                'avatar' => $request->avatar
//            ]);
//            $changed[]='avatar';
//        }

        if ($request->has('avatar_original') && $request->avatar_original) {
            $user->update([
                'avatar_original' => $request->avatar_original
            ]);
            $changed[] = 'avatar_original';
        }

        if ($request->has('address') && $request->address) {
            $user->update([
                'address' => $request->adress
            ]);
            $changed[] = 'address';
        }

        if ($request->has('phone') && $request->phone) {
            $user->update([
                'phone' => $request->phone
            ]);
        }

        if ($request->has('country') && $request->country) {
            $user->update([
                'country' => $request->country
            ]);
            $changed[] = 'country';
        }

        if ($request->has('city') && $request->city) {
            $user->update([
                'city' => $request->city
            ]);
            $changed[] = 'city';
        }

        if ($request->has('postal_code') && $request->postal_code) {
            $user->update([
                'postal_code' => $request->postal_code
            ]);
            $changed[] = 'postal_code';
        }

        if ($request->has('postal_code') && $request->postal_code) {
            $user->update([
                'postal_code' => $request->postal_code
            ]);
            $changed[] = 'postal_code';
        }

        if ($request->has('date_of_birth') && $request->date_of_birth) {
            $user->update([
                'date_of_birth' => $request->date_of_birth
            ]);
            $changed[] = 'date_of_birth';
        }

        if ($request->has('full_name')) {
            $user->update([
                'full_name' => $request->full_name
            ]);
            $changed[] = 'full_name';
        }


        if ($request->has('gender') && $request->gender) {
            $user->update([
                'gender' => $request->gender
            ]);
            $changed[] = 'gender';
        }

        if ($request->has('full_address') && $request->full_address) {
            $user->update([
                'full_address' => $request->full_address
            ]);
            $changed[] = 'full_address';
        }

        if ($request->hasFile('profile_image')) {
            $user->uploadProfileImage($request->file('profile_image'));
            $changed[] = 'profile_image';
        }

        if ($request->has('avatar')) {

            $folderPath = "/images/avatar/";

            $image_parts = explode(";base64,", $request->get('avatar'));
            $image_type_aux = explode("image/", $image_parts[0]);
            $image_type = $image_type_aux[1];
            $image_base64 = base64_decode($image_parts[1]);
            $file = "avatar-" . time() . "." . $image_type;

            Storage::put('/images/avatar/' . $file, $image_base64);

            $user->update([
                'avatar' => 'public/images/avatar/' . $file
            ]);

            $changed[] = 'avatar2';
            $changed['filename'] = 'public/images/avatar/' . $file;
        }
        $changed['user'] = $user;

        return response()->json([
            'message' => 'Profile information has been updated successfully',
            'changed_fields' => $changed
        ]);

    }
}
