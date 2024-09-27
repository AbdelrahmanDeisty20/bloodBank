<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Mail\ResetPassword;
use App\Models\BloodType;
use App\Models\Client;
use App\Models\Governorate;
use App\Models\Token;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function register()
    {
        $bloodTypes = BloodType::all();
        $governorates = Governorate::all();
        return view('front.create-account', compact('governorates', 'bloodTypes'));
    }
    public function registerSave(Request $request)
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
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $random = Str::random(40);
        // $request->merge(['password' => bcrypt($request->password)]);
        $client = Client::create($request->all());
        $client->api_token = $random;
        $client->save();
        return redirect()->back()->with('success', 'تم انشاء حساب جديد بنجاح');
    }
    public function login()
    {
        return view('front.signin-account');
    }
    public function loginSave(Request $request)
    {
        $validator = validator()->make(request()->all(), [
            'phone' => 'required',
            'password' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }
        $client = Client::where('phone', $request->phone)->first();
        if ($client) {
            if (Hash::check($request->password, $client->password)) {
                auth('client-web')->login($client);
                return redirect()->route('front.home')->with('success', 'تم الدخول بنجاح');
            } else {
                return redirect()->route('login-client')->with('error', 'بيانات الدخول غير صحيحة');
            }
        } else {
            return redirect()->route('login-client')->with('error', 'لايوجد حساب مرتبط بهذا');
        }
    }
    public function notificationList(Request $request)
{
    $client = $request->user();
    $notifications = $client->notifications()
        ->latest()
        ->paginate(10);
    return resposeJison(1, 'Notifications List', $notifications);
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
    public function logout()
    {
        $clients = Client::first();
        Auth::guard('client-web')->logout($clients);
        return redirect()->route('front.home');

    }
    public function profile(Request $request)
{
    return view('front.profile');
}
    public function profileSave(Request $request ){
        $validator = validator()->make(request()->all(), [
            'password' => 'confirmed',
            'email' => Rule::unique('clients')->ignore($request->user()->id),
            'phone' => Rule::unique('clients')->ignore($request->user()->id),
            ]);
            if ($validator->fails()) {
                $data = $validator->errors();
                return redirect()->back()->withErrors($$data)->withInput();
                // return resposeJison(status: 0, msg: $validator->errors()->first(),data:$data);
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

            return redirect()->back()->with('success', 'تم التعديل بنجاح');
        }
        public function ressetPassword()
        {
            return view('front.reset-password');
        }
        public function Password(Request $request)
    {
        $validator = validator()->make(request()->all(), [
            'phone' => 'required'
        ]);
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
            // return resposeJison(status: 0, msg: $validator->errors()->first(), data: $validator->errors());
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
                    return redirect()->back()->with('success', 'تم ارسال الكود التحقق بنجاح');

                // return resposeJison(status: 1, msg: 'تم ارسال كود التحقق', data: ['pin_code_for_test' => $code]);
            } else {
                return redirect()->back()->with('error', 'يوجد خطأ');
                // return resposeJison(status: 0, msg: 'حدث خطأ ما');
            }
        } else {
            return redirect()->back()->with('error', 'لايوجد حساب مرتبط بهذا الهاتف');
            // return resposeJison(status: 0, msg: 'لايوجد حساب مرتبط بهذا الهاتف');
        }
    }
    public function thePassword()
    {
        return view('front.new-password');
    }
    public function newPassword(Request $request)
    {
        $validator = validator()->make(request()->all(), [
            'phone' => 'required',
            'pin_code' => 'required',
            'password' => 'required|confirmed',
        ]);
        if ($validator->fails()) {
            $data = $validator->errors();
            return redirect()->back()->withErrors($data)->withInput();

            // return resposeJison(status: 0, msg: $validator->errors()->first(), data: $data);
        }
        $user = Client::where('pin_code', request()->pin_code)->where('pin_code', '!=', 0)
            ->where('phone', $request->phone)->first();
        if ($user) {
            $user->password = request()->password;
            $user->pin_code = null;
            if ($user->save()) {
                return redirect()->back()->with('success', 'تم تغيير كلمة المرور بنجاح');
                // return resposeJison(status: 1, msg: 'تم تغيير كلمة المرور بنجاح');
            } else {
                return redirect()->back()->with('success', 'حدث خطأ ما, حاول مرة اخرى');
                // return resposeJison(status: 0, msg: ' حدث خطأ ما, حاول مرة اخرى');
            }
        } else {
            return redirect()->back()->with('success', 'كود التحقق غير صحيح, حاول مرة اخرى');
            // return resposeJison(status: 0, msg: 'كود التحقق غير صحيح, حاول مرة اخرى');
        }
    }

}
