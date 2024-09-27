<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\City;
use App\Models\Donation;
use App\Models\Contact;
use App\Models\Governorate;
use App\Mail;
use App\Models\DonationRequest;
use App\Models\Post;
use App\Models\Setting;
// use App\Models\BloodType;
use App\Models\State;
use App\Models\Token;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{

    public function governorates()
    {
        $governorates = Governorate::all();
        return resposeJison(status: 1, msg: 'success', data: $governorates);
        // return $governorates;
    }
    public function cities(Request $request)
    {
        $cities = City::where(function ($query) use ($request) {
            if ($request->has(key: 'governorate_id')) {
                $query->where('governorate_id', $request->governorate_id);
            }
        })->get();
        return resposeJison(status: 1, msg: 'success', data: $cities);
    }
    public function posts()
    {
        $posts = Post::all();
        return resposeJison(status: 1, msg: 'success', data: $posts);
    }
    public function donation_request_create(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'patient_name' => 'required',
            'patient_phone' => 'required|digits:11',
            'hospital_name'=>'required',
            'blood_type_id' => 'required',
            'patient_age' => 'required|digits_between:1,120',
            'bags_num' => 'required|digits_between:1,10',
            'hospital_address' => 'required',
            // 'noties' => 'required',
            'details' => 'required',
            'latitude' => 'required',
            'longtude' => 'required',
            'city_id' => 'required|exists:cities,id',
            // 'client_id' => 'required|exists:clients,id'
        ]);
        if ($validator->fails()) {
            return resposeJison(status: 0, msg: $validator->errors()->first(), data: $validator->errors());
        }
        //create donationRequest:
        $donationRequest = $request->user()->requests()->create($request->all());
        $clientIds = $donationRequest->city->governorate->clients()
            ->whereHas('bloodTypes', function ($q) use ($request) {
                $q->where('blood_types.id', $request->blood_type_id);
            })->pluck('clients.id')->toArray();
        //send notification to clients
        if (count($clientIds)) {
            $notification = $donationRequest->notifications()->create([
                'title' => ' يوجد حالة قريبة منك ',
                'content' => $request->user()->name . ' محتاج متبرع لفصيلة',

            ]);
            //attach to notifications!
            $notification->clients()->attach($clientIds, ['is_read' => false]);
            $tokens = Token::whereIn('client_id', $clientIds)->where('token', '!=', null)->pluck('token')->toArray();


            //get tokens for FCM (push notification using firebase cloud)


            //$tokens = $client->tokens()->where('token', '!=', '')
            //->whereIn('client_id', $clientIds)->pluck('token')->toArray();


            if (count($tokens)) {
                $audience = ['include_players_ids' => $tokens];
                $content = [
                    'ar' => 'يوجد اشعار من ل' . $request->user()->name(),
                    'er' => 'You have a new noti' . $request->user()->name(),
                ];
                $title = $notification->title;
                $content = $notification->content;
                $data = [
                    // 'action'=>'new notify',
                    // 'data'=>null,
                    // 'client'=>'client',
                    // 'title'=>$notification->title,
                    // 'content'=>$notification->content,
                    'donation_request_id' => $donationRequest->id,
                ];
                info(json_encode($data));
                $send = notifyByfirebase($title, $content, $tokens, $data);
                info($send);
                info("firebase result: " . $send);
                $send = json_decode($send);
            }
        }
        return resposeJison(status: 1, msg: 'تمت الاضافة بنجاح', data: compact('donationRequest'));
    }
    public function donationRequest(Request $request)
    {
        // RequestLog::create(['content' => $request->all(), 'service' => 'donation details']);
        $donation = DonationRequest::with('city', 'clients')->find($request->donation_id);
        if (!$donation) {
            return resposeJison(status: 0, msg: '404 no donation found');
        }
        return resposeJison(status: 1, msg: 'success', data: $donation);
    }


    public function donationRequests(Request $request)
    {
        // RequestLog::create(['content' => $request->all(), 'service' => 'donation details']);
        $donations = DonationRequest::with('city', 'clients')->paginate();
        return resposeJison(status: 1, msg: 'success', data: $donations);
    }


    public function myFavourites(Request $request)
    {
        // RequestLog::create(['content' => $request->all(), 'service' => '']);
        $posts = $request->user()->favourites()->latest()->paginate(20);
        return resposeJison(status: 1, msg: 'loaded...', data: $posts);
    }
    public function postFavourite(Request $request)
    {
        // RequestLog::create(['content' => $request->all(), 'service' => 'post toggle favourite']);
        $ruls = [
            'post_id' => 'required|exists:posts,id'
        ];
        $validator = Validator()->make(request()->all(), $ruls);
        if ($validator->fails()) {
            return resposeJison(status: 0, msg: $validator->errors()->first());
        }
        $toggle = $request->user()->favourites()->toggle($request->post_id);
        return resposeJison(status: 1, msg: 'success', data: $toggle);
    }
    public function notifications(Request $request)
    {
        $items = $request->user()->notifications()->latest()->paginate(10);
        return resposeJison(status: 1, msg: 'loaded...', data: $items);
    }
    public function notificationsCount(Request $request)
    {
        return resposeJison(status: 1, msg: 'loaded...', data: [
            'notifications_count' => $request->user()->notifications()->count()
        ]);
    }
    public function logs()
    {
        $requests = RequestLog::latest()->paginate(50);
        return $requests;
    }
    public function contact(Request $request)
    {
        $validator = Validator()->make($request->all(), [
            'subject' => 'required',
            'email' => 'required|email',
            'messge' => 'required',
            'name' => 'required',
            'phone' => 'required',
        ]);

        if ($validator->fails()) {
            return resposeJison(status: 0, msg: $validator->errors()->first(), data: $validator->errors());
        }


        $contact = Contact::create($request->all());

        return resposeJison(status: 1, msg: 'Contact request submitted successfully', data: []);
    }
    public function settings()
{
    $settings = Setting::first();
    return resposeJison(status: 1, msg: 'Settings loaded successfully', data: $settings);
}
public function notificationSettings(Request $request)
{
    $validator = Validator()->make($request->all(), [
        // 'is_active' => 'required|boolean',
        'blood_types' => 'required|array',
        'blood_types.*' => 'required|exists:blood_types,id',
        'governorates'=>'required|array',
        'governorates.*'=>'required|exists:governorates,id',
    ]);

    if ($validator->fails()) {
        return resposeJison(status: 0, msg: $validator->errors()->first(), data: $validator->errors());
    }

    $request->user()->bloodTypes()->sync($request->blood_types);
    $request->user()->governorates()->sync($request->governorates);

    return resposeJison(status: 1, msg: 'Notification settings updated successfully', data: []);
}
}
