<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\BloodTypes;
use App\Models\Client;
use App\Models\Token;
// use App\Models\City;
// use App\Models\Governorate;
// use Illuminate\Support\Str;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'name' => 'required',
            'email' => 'required|email|unique:clients',
            'birth_date' => 'required',
            'city_id' => 'required',
            'phone' => 'required|unique:clients',
            // 'donation_last_date' => 'required',
            'password' => 'required|confirmed',
            'blood_type_id' => 'required'
        ]);
        if ($validator->fails()) {
            return resposeJison(status: 0, msg: $validator->errors()->first(), data: $validator->errors());
        }
        $random = Str::random(40);
        // $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = $random;
        $client->save();
        return resposeJison(status: 1, msg: 'تم الاضافة بنجاح ', data: [
            'api_token' => $client->api_token,
            'client' => $client
        ]);

        // return $request->all();
    }
    public function registerToken(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'token' => 'required',
            'platform' => 'required|in:android,ios'
        ]);
        if ($validator->fails()) {
            $data = $validator->errors();
            return resposeJison(status: 0, msg: $validator->errors()->first(), data: $data);
        }
        Token::where('token',$request->token)->delete();
        $request->user()->tokens()->create($request->all());
        // Token::create([
        //     'token' => $request->token,
        //     'platform' => $request->platform,
        //     'user_id' => $request->user()->id
        // ]);
        return resposeJison(status: 1, msg: 'تم التسجيل بنجاح');
    }
    public function removeToken(Request $request)
    {
        $validator = validator()->make($request->all(),[
            'token' => 'required'
        ]);
        if ($validator->fails()) {
            $data = $validator->errors();
            return resposeJison(status: 0, msg: $validator->errors()->first(),data:$data);
        }
        Token::where('token',$request->token)->delete();
        return resposeJison(status: 1, msg: 'تم الحذف بنجاح');

    }
    public function login(Request $request)
    {
        $validator = validator()->make(request()->all(), [
            'phone' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return resposeJison(status: 0, msg: $validator->errors()->first(), data: $validator->errors());
        }
        $client = Client::where('phone',$request->phone)->first();
        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                return resposeJison(status: 1, msg: 'تم تسجيل الدخول', data: [
                    'api_token' => $client->api_token,
                    'client' => $client
                ]);
            } else {
                return resposeJison(status: 0, msg: 'بيانات الدخول غير صحيحة');
            }
        } else {
            return resposeJison(status: 0, msg: 'لايوجد حساب مرتبط بهذا!');
        }
    }
    public function resetPassword(Request $request)
    {
        $validator = validator()->make(request()->all(), [
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return resposeJison(status: 0, msg: $validator->errors()->first(), data: $validator->errors());
        }
        $user = Client::where('phone', request()->phone)->first();
        if ($user) {
            $code = rand(1111, 9999);
            $user->pin_code = $code;
            $update = $user->update(['pin_code' => $code]);
            if ($update) {
                smsMisr($request->phone, message: 'your reset code is: ' . $code);

                Mail::to($user->email) // Use $user->email instead of $user->email()
                    // ->cc($moreUsers)
                    ->bcc("abdeisty33@gmail.com")
                    ->send(new ResetPassword($code));

                return resposeJison(status: 1, msg: 'تم ارسال كود التحقق', data: ['pin_code_for_test' => $code]);
            } else {
                return resposeJison(status: 0, msg: 'حدث خطأ ما');
            }
        } else {
            return resposeJison(status: 0, msg: 'لايوجد حساب مرتبط بهذا الهاتف');
        }
    }
    public function password(Request $request)
    {
        $validator = validator()->make(request()->all(), [
            'phone' => 'required',
            'pin_code' => 'required',
            'password' => 'required|confirmed',
        ]);
        if ($validator->fails()) {
            $data = $validator->errors();
            return resposeJison(status: 0, msg: $validator->errors()->first(), data: $data);
        }
        $user = Client::where('pin_code', request()->pin_code)->where('pin_code', '!=', 0)
            ->where('phone', $request->phone)->first();
        if ($user) {
            $user->password = bcrypt(request()->password);
            $user->pin_code = null;
            if ($user->save()) {
                return resposeJison(status: 1, msg: 'تم تغيير كلمة المرور بنجاح');
            } else {
                return resposeJison(status: 0, msg: ' حدث خطأ ما, حاول مرة اخرى');
            }
        } else {
            return resposeJison(status: 0, msg: 'كود التحقق غير صحيح, حاول مرة اخرى');
        }
    }
    public function profile(Request $request ){
        $validator = validator()->make(request()->all(), [
            'password' => 'confirmed',
            'email' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore($request->user()->id),
            ]);
            if ($validator->fails()) {
                $data = $validator->errors();
                return resposeJison(status: 0, msg: $validator->errors()->first(),data:$data);
            }
            $loginUser= $request->user();
            $loginUser->update($request->all());

            // if($loginUser->has('password'))
            // {
            //     $loginUser->password = bcrypt(request()->password);
            // }


            // if($request->has('governorate_id'))
            // {
            //     $loginUser->cities()->detach($request->city_id);
            //     $loginUser->cities()->attach($request->city_id);
            // }
            // if($request->has('blood_type_id'))
            // {
            //     $bloodType= BloodTypes::where('name',$request->Blood_type->first());
            //     $loginUser->blood_type()->detach($bloodType->blood_type);
            //     $loginUser->blood_type()->attach($bloodType->blood_type);
            // }

            return resposeJison(status: 1, msg: 'تم تعديل البيانات');
    }
    public function notificationList(Request $request)
{
    $client = $request->user();
    $notifications = $client->notifications()
        ->latest()
        ->paginate(10);
    return resposeJison(1, 'Notifications List', $notifications);
}
}
