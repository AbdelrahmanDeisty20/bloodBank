<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\BloodType;
use App\Models\City;
use App\Models\Client;
use App\Models\Contact;
use App\Models\DonationRequest;
use App\Models\Governorate;
use App\Models\Post;
use App\Models\Token;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MainController extends Controller
{
    public function home(Request $request)
    {
        $clients = Client::first();
        // auth('client-web')->login($clients);
        // Auth::guard('client-web')->logout();
        // dd(auth('client-web' )->user());
        $bloodTypes = BloodType::all();
        $cities = City::all();
        $donations = DonationRequest::with('bloodType', 'city')
            ->where(function ($query) use ($request) {
                if ($request->city) {
                    $query->where('city_id', 'like', '%' . $request->city . '%');
                }
                if ($request->city) {
                    $query->where('blood_type_id', 'like', '%' . $request->blood_type . '%');
                }
                //
            })
            ->where('created_at', '<', Carbon::now())->take(6)->get();
        // $posts = Post::all();
        $posts = Post::where('created_at', '<', Carbon::now()->toDateString())->take(9)->get();
        return view('front.home', compact('posts', 'donations', 'cities', 'bloodTypes'));
    }

    public function whoAreUs()
    {
        return view('front.who-are-us');
    }
    public function about()
    {
        return view('front.about');
    }


    public function toggleFavourite(Request $request)
    {
            $toggle = $request->user()->posts()->toggle($request->post_id);
            return resposeJison(1, 'success', $toggle);
    }
    public  function donationRequests(Request $request)
    {
        $bloodTypes = BloodType::all();
        $cities = City::all();
        $donations = DonationRequest::with('bloodType', 'city')
            ->where(function ($query) use ($request) {
                if ($request->city) {
                    $query->where('city_id', 'like', '%' . $request->city . '%');
                }
                if ($request->city) {
                    $query->where('blood_type_id', 'like', '%' . $request->blood_type . '%');
                }
                //
            })->paginate(20);
        return view('front.donation-requests', compact('donations', 'bloodTypes', 'cities'));
    }
    public function donationInformation($id)
    {
        $donation = DonationRequest::with('bloodType', 'city')->find($id);
        if (!$donation) {
            return redirect()->back()->with('error', 'لايوجد متبرع بهذا الاسم');
        }
        return view('front.inside-request', compact('donation'));
    }
    public function contactUs()
    {
        return view('front.contact-us');
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

        return redirect()->back()->with('success', 'تم الارسال بنجاح وسيتم التواصل معك قريبا');
    }
    public function posts()
    {
        $posts = Post::with('category')->paginate(20);
        return view('front.posts', compact('posts'));
    }
    public function postMore($id)
    {
        $posts = Post::paginate(20);
        $post = Post::with('category')->find($id);
        if (!$post) {
            return redirect()->back()->with('error', 'لايوجد مقالة بنفس الاسم حاليا');
        }
        return view('front.article-details', compact('post', 'posts'));
    }
    public function donation_request_create()
    {
        $bloodTypes = BloodType::all();
        $cities = City::all();
        return view('front.create-donation', compact('bloodTypes', 'cities'));
    }
    public function donation_request_create_save(Request $request)
    {
        $validator = validator()->make($request->all(), [
            'patient_name' => 'required',
            'patient_phone' => 'required|digits:11',
            'hospital_name' => 'required',
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
            return redirect()->back()->withErrors($validator)->withInput();

            // return resposeJison(status: 0, msg: $validator->errors()->first(), data: $validator->errors());
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
        return redirect()->route('donation-requests.donationRequests')->with('success', 'تم الاضافة بنجاح');    }
}
