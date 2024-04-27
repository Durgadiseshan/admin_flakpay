<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use App\User;
use App\Employee;
use App\ContactUs;
use App\RyapayBlog;
use App\MerchantBusiness;
use App\Http\Controllers\SmsController;
use App\Classes\ValidationMessage;
use App\Mail\SendMail;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Input;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Auth;
use App\RyapayGallery;
use App\RyapayCareer;
use App\RyapayApplicant;
use App\RyapayEvent;
use App\Custom;
use App\Classes\RupayapaySecureData;

class VerifyController extends Controller
{
    /**
     * verify the user with a given token.
     * 
     * @param string $token
     * @return Response
     * 
     */

    protected $date_time;

    public $password_attempt_count;

    public $resend_message_attempt_count;

    public function __construct()
    {
        $this->date_time = date("Y-m-d H:i:s");
        $this->password_attempt_count = 0;
        $this->resend_message_attempt_count = 0;
    }

    private function _arrayPaginator($array, $request, $module = "")
    {
        $page = Input::get('page', 1);
        $perPage = 10;
        $offset = ($page * $perPage) - $perPage;

        /*return new LengthAwarePaginator(array_slice($array, $offset, $perPage, true), count($array), $perPage, $page,
            ['path' => $request->url(), 'query' => $request->query()]);*/

        return new LengthAwarePaginator(
            array_slice($array, $offset, $perPage, true),
            count($array),
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );
    }

    public function verify_email_account($token)
    {

        $result = User::where('verify_token', $token)->firstOrFail();
        if ($result->id != "") {
            User::where('id', $result->id)->update(['is_verified' => 'y', 'is_email_verified' => 'y', 'verify_token' => '']);
        }
        return redirect()->route('dashboard');
    }


    public function verify_mobile_number(Request $request)
    {


        $OTP_submitted = $request->otp_number;

        if ($OTP_submitted == session("OTP")) {
            $result = User::where('merchant_gid', $request->merchant_gid)->firstOrFail();
            if ($result->id != "") {
                User::where('id', $result->id)->update(['is_mobile_verified' => 'y']);
            }
            return redirect("/business-details");
        } else {

            if ($OTP_submitted == "") {
                $message = "OTP is empty";
            } else {
                $message = "Entered OTP is wrong";
            }
            return redirect()->back()->with("fail", $message);
        }
    }

    // public function resend_mobile_sms()
    // {
    //     $user_details = User::where('merchant_gid',session("merchant_gid"))->firstOrFail();

    //     if(session()->has("resend_message_attempt_count"))
    //     {
    //         session(["resend_message_attempt_count"=>session("resend_message_attempt_count")+1]);
    //     }else{
    //         session(["resend_message_attempt_count"=>$this->resend_message_attempt_count+1]);
    //     }

    //     if(session("resend_message_attempt_count") < 4)
    //     {
    //         if($user_details->name != "" && $user_details->mobile_no !="")
    //         {
    //             $OTP = mt_rand(99999,1000000);

    //             $message = "Dear ".$user_details->name." Thanks for registering with Rupayapay.\nPlease verify your mobile number by entering the below OTP ".$OTP;

    //             $sms = new SmsController($message,$user_details->mobile_no);

    //             session(['merchant_gid' =>$user_details->merchant_gid,"OTP"=>$OTP]);

    //             $sms_response = $sms->sendMessage();

    //             //$sms_status = explode("|",$sms_response);

    //             switch (session("resend_message_attempt_count")) {
    //                 case '1':

    //                     $message = "Message Sent Successfully";
    //                     break;
    //                 case '2':
    //                     $message = "Message Sent Successfully";
    //                     break;
    //                 case '3':
    //                     $message = "Message Sent Successfully! To many message attempts may lock your account temporary";
    //                     break;
    //             }
    //             return redirect()->back()->with("message-success",$message);
    //             //echo json_encode(array("status"=>TRUE,"message"=>"OTP has sent to your registered mobile no."));

    //         }

    //     }else{

    //         $user_details->update_merchant(["is_account_locked"=>"Y"]);

    //         session()->forget('resend_message_attempt_count');

    //         $message = "Your account got locked temporary.Please contact our customer support team!";

    //         return redirect("/account-locked")->with("account-locked",$message);
    //     }


    // }

    public function store_merchant_info(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'business_type_id' => 'required',
            'business_expenditure' => 'required',
            'business_name' => 'required|string|regex:/^[a-zA-Z ]+$/u',
            'address' => 'required',
            'pincode' => 'required|numeric|digits:6',
            "city" => 'required|string|regex:/^[a-zA-Z ]+$/u',
            "state" => 'required',
            "country" => 'required',
        ], [
            'business_name.regex' => "Company name doesn't allow special characters only alphabets",
            "city.regex" => "City field doesn't allow special characters or numbers only alphabets"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator->errors());
        } else {


            User::where('id', Auth::user()->id)->update(['merchant_business' => 'Y']);

            $merchant_business = new MerchantBusiness();
            $business_details = $request->except("_token");
            $business_details["created_date"] = $this->date_time;
            $business_details["created_merchant"] = Auth::user()->id;

            $insert_status = $merchant_business->add_merchant_business($business_details);

            if ($insert_status) {
                return redirect('/merchant/dashboard');
            }
        }
    }


    public function session_timeout(Request $request)
    {
        return view("/merchant/sessiontimeout");
    }

    public function emp_session_timeout(Request $request)
    {
        return view("/employee/sessiontimeout");
    }


    public function session_update(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with("errors", $validator->errors());
        } else {
            $user = User::where('id', Auth::user()->id)->firstOrFail();
            if (password_verify($request->password, $user->password)) {

                session(["password_attempt_count" => $this->password_attempt_count]);
                $user->update_merchant(["last_seen_at" => date("Y-m-d H:i:s")]);
                return redirect(session("nextpage"));
            } else {
                if (session()->has("password_attempt_count")) {
                    session(["password_attempt_count" => session("password_attempt_count") + 1]);
                } else {
                    session(["password_attempt_count" => $this->password_attempt_count + 1]);
                }

                if (session("password_attempt_count") < 4) {

                    switch (session("password_attempt_count")) {
                        case '1':

                            $message = "Only " . (session("password_attempt_count")) . "/3 Passwords Attempts left";
                            break;
                        case '2':
                            $message = "Only " . (session("password_attempt_count")) . "/3 Passwords Attempts left";
                            break;
                        case '3':
                            $message = "Account will get lock temporary, If you fail this time";
                            break;
                    }

                    return redirect()->back()->with("passwordAttempts", $message);
                } else {

                    $user->update_merchant(["is_account_locked" => "Y"]);
                    session()->forget('password_attempt_count');
                    $message = "Your account got locked temporary.Please contact our customer support team!";
                    return redirect("/account-locked")->with("account-locked", $message);
                }
            }
        }
    }


    public function emp_session_update(Request $request)
    {


        $validator = Validator::make($request->all(), [
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with("errors", $validator->errors());
        } else {
            $employee = Employee::where('id', Auth::guard("employee")->user()->id)->firstOrFail();
            if (password_verify($request->password, $employee->password)) {

                $employee->update_my_details(["last_seen_at" => date("Y-m-d H:i:s")], ["id" => Auth::guard("employee")->user()->id]);
                session(["password_attempt_count" => $this->password_attempt_count]);
                return redirect(session("nextpage"));
            } else {

                if (session()->has("password_attempt_count")) {
                    session(["password_attempt_count" => session("password_attempt_count") + 1]);
                } else {

                    session(["password_attempt_count" => $this->password_attempt_count + 1]);
                }

                if (session("password_attempt_count") < 4) {

                    switch (session("password_attempt_count")) {
                        case '1':

                            $message = "Only " . (session("password_attempt_count")) . "/3 Passwords Attempts left";
                            break;
                        case '2':
                            $message = "Only " . (session("password_attempt_count")) . "/3 Passwords Attempts left";
                            break;
                        case '3':
                            $message = "Account will get lock temporary, If you fail this time";
                            break;
                    }

                    return redirect()->back()->with("passwordAttempts", $message);
                } else {

                    $employee->update_my_details(["is_account_locked" => "Y", ["id" => Auth::guard("employee")->user()->id]]);
                    session()->forget('password_attempt_count');
                    $message = "Your account got locked temporary.Please contact our customer support team!";
                    return redirect("/account-locked")->with("account-locked", $message);
                }
            }
        }
    }

    public function account_locked()
    {
        return view("/merchant/accountlocked");
    }

    public function firsttime_passwordchange()
    {

        return view('employee.ftpasswordchange');
    }

    public function rupayapay_email_otp()
    {
        return view('employee.emailotp');
    }

    public function rupayapay_mobile_otp()
    {
        return view('employee.mobileotp');
    }

    public function contact_us()
    {
        return view('contactus')->with("loadcss", "contact");
    }

    public function rupayapay_contactus(Request $request)
    {

        $rules = [
            "first_name" => "required|min:3|max:50|string",
            "last_name" => "required|min:3|max:50|string",
            "email" => "required|max:50|email",
            "mobile_no" => "required|digits:10",
            "subject" => "required|string",
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return redirect()->back()->withInput($request->input())->withErrors($validator->errors());
        } else {

            $form_data = $request->except("_token");
            $contact_us = new ContactUs();
            $form_data["name"] = $request->first_name . " " . $request->last_name;
            $form_data["created_date"] = $this->date_time;

            $insert_status = $contact_us->add_contactus($form_data);

            if ($insert_status) {

                $data = array(
                    "from" => env("MAIL_USERNAME", ""),
                    "subject" => "Thank You For Contacting Us",
                    "view" => "/maillayouts/contactusmail",
                    "htmldata" => array(
                        "name" => $form_data["name"],
                        "email" => $form_data["email"],
                    ),
                );

                Mail::to($request->email)->send(new SendMail($data));

                return redirect()->back()->with("success", "Your form submitted successfully");
            } else {
                return redirect()->back()->with("failed", "Unable to submmit your form please try again");
            }
        }
    }

    public function blog(Request $request)
    {
        $blog_posts = new RyapayBlog();
        $posts = $blog_posts->get_all_posts();
        $recent_posts = $blog_posts->get_recent_posts();
        $posts_paginate = $this->_arrayPaginator($posts, $request, "postspaginate");
        return view('postlist')->with(["posts" => $posts_paginate, "recent_posts" => $recent_posts, "loadcss" => "contact"]);
    }

    public function blog_post(Request $request, $id)
    {
        $blog_posts = new RyapayBlog();
        $recent_posts = $blog_posts->get_recent_posts();
        $post = $blog_posts->show_post($id)[0];
        if (!empty($post)) {
            return view('post')->with(["post" => $post, "recent_posts" => $recent_posts, "loadcss" => "contact"]);
        } else {

            return redirect()->back();
        }
    }

    public function rupayapay_subscribe(Request $request)
    {

        if (isset($request->email) && !empty($request->email)) {

            echo json_encode(["status" => TRUE, "message" => "Thank you for subscribing with us"]);
        } else {
            echo json_encode(["status" => FALSE, "message" => "Please provide your email to subscribe with us"]);
        }
    }

    public function gallery(Request $request)
    {

        $gallerObject = new RyapayGallery();
        $galleryimages = $gallerObject->get_gallery();

        $carousal = [];
        $introduction = [];
        $footer = [];

        foreach ($galleryimages as $key => $value) {
            if ($value->image_position == "73") {
                $carousal[$key]["image_name"] =  $value->image_name;
                $carousal[$key]["content"] =  $value->content;
            } elseif ($value->image_position == "74") {
                $introduction[$key]["image_name"] =  $value->image_name;
                $introduction[$key]["content"] =  $value->content;
            } else {
                $footer[$key]["image_name"] =  $value->image_name;
                $footer[$key]["content"] =  $value->content;
            }
        }

        return view('gallery')->with(["loadcss" => "gallery", "loadscript" => "gallery", "carousal" => $carousal, "introduction" => $introduction, "footer" => $footer]);
    }

    public function career(Request $request)
    {

        $careerObject = new RyapayCareer();
        $jobdetails = $careerObject->get_posted_jobs();

        $technical = [];
        $nontechnical = [];

        foreach ($jobdetails as $key => $value) {
            if ($value->job_category == "76") {
                $technical[] = [
                    "id" => $value->id,
                    "job_title" => $value->job_title,
                    "job_description" => $value->job_description,
                    "job_location" => $value->job_location,
                ];
            } else {
                $nontechnical[] = [
                    "id" => $value->id,
                    "job_title" => $value->job_title,
                    "job_description" => $value->job_description,
                    "job_location" => $value->job_location,
                ];
            }
        }

        return view('career')->with(["loadcss" => "career", "loadscript" => "career", "tech" => $technical, "nontech" => $nontechnical]);
    }

    public function integration(Request $request)
    {

        return view('integration')->with(["loadcss" => "integration"]);
    }


    public function get_job_description(Request $request, $id)
    {

        if ($request->ajax()) {
            $careerObject = new RyapayCareer();
            $jobdetails = $careerObject->get_job_description($id);
            echo json_encode($jobdetails);
        }
    }

    public function csr(Request $request)
    {

        $blog_posts = new RyapayBlog("csr");
        $posts = $blog_posts->get_all_posts();
        $recent_posts = $blog_posts->get_recent_posts();
        $posts_paginate = $this->_arrayPaginator($posts, $request, "postspaginate");
        return view('csrpostlist')->with(["posts" => $posts_paginate, "recent_posts" => $recent_posts, "loadcss" => "csr"]);
    }

    public function csr_post(Request $request, $id)
    {
        $blog_posts = new RyapayBlog("csr");
        $recent_posts = $blog_posts->get_recent_posts();
        $post = $blog_posts->show_post($id);
        if (!empty($post)) {
            return view('csrpost')->with(["post" => $post[0], "recent_posts" => $recent_posts, "loadcss" => "csr"]);
        } else {

            return redirect()->back();
        }
    }

    public function press_release(Request $request)
    {

        $blog_posts = new RyapayBlog("press-release");
        $posts = $blog_posts->get_all_posts();
        $recent_posts = $blog_posts->get_recent_posts();
        $posts_paginate = $this->_arrayPaginator($posts, $request, "postspaginate");
        return view('prpostlist')->with(["posts" => $posts_paginate, "recent_posts" => $recent_posts, "loadcss" => "press-release"]);
    }

    public function pr_post(Request $request, $id)
    {
        $blog_posts = new RyapayBlog("press-release");
        $recent_posts = $blog_posts->get_recent_posts();
        $post = $blog_posts->show_post($id);
        if (!empty($post)) {
            return view('prpost')->with(["post" => $post[0], "recent_posts" => $recent_posts, "loadcss" => "press-release"]);
        } else {

            return redirect()->back();
        }
    }

    public function event()
    {

        $event_posts = new RyapayEvent();
        $posts = $event_posts->get_event_posts();

        $recent_events = [];
        $past_events = [];
        $upcoming_events = [];

        foreach ($posts as $key => $object) {
            if ($object->type == 'past') {
                $past_events[] = [
                    "event_name" => $object->event_name,
                    "event_image" => $object->event_image,
                    "event_date" => $object->event_date,
                    "event_description" => $object->event_description,
                    "event_short_url" => $object->event_short_url
                ];
            } else if ($object->type == 'recent') {
                $recent_events[] = [
                    "event_name" => $object->event_name,
                    "event_image" => $object->event_image,
                    "event_date" => $object->event_date,
                    "event_description" => $object->event_description,
                    "event_short_url" => $object->event_short_url
                ];
            } else {
                $upcoming_events[] = [
                    "event_name" => $object->event_name,
                    "event_image" => $object->event_image,
                    "event_date" => $object->event_date,
                    "event_description" => $object->event_description,
                    "event_short_url" => $object->event_short_url
                ];
            }
        }

        $load_elements = [
            "loadcss" => "event",
            "past_events" => $past_events,
            "recent_events" => $recent_events,
            "upcoming_events" => $upcoming_events
        ];

        return view('eventlist')->with($load_elements);
    }

    public function event_post(Request $request, $id)
    {

        $event_posts = new RyapayEvent();
        $post = $event_posts->get_event_post($id);

        if (!empty($post)) {
            $load_elements = [
                "loadcss" => "event",
                "post" => $post[0]
            ];
            return view('eventpost')->with($load_elements);
        } else {

            return redirect()->back();
        }
    }

    public function generate_qrcode(Request $request, $url = "")
    {

        if ($url != "") {
            return QrCode::size("250")->generate($url);
        }
    }

    public function store_applicant(Request $request)
    {
        if ($request->ajax()) {

            $rules = [
                "applicant_name" => "required|string",
                "applicant_email" => "required|string",
                "applicant_mobile" => "required|digits:10|numeric",
                "applicant_resume" => "required|file|mimes:pdf,doc,docx|max:5000",
            ];

            $messages = [
                "applicant_name.required" => "Name Field is mandatory",
                "applicant_email.required" => "Email Field is mandatory",
                "applicant_mobile.required" => "Mobile Field is mandatory",
                "applicant_resume.required" => "Resume Attachment is mandatory",
                "applicant_resume.image" => "Only Files are accepted",
                "applicant_resume.mimes" => "Pdf,Doc or Docx files are only accepted"
            ];

            $validator = Validator::make($request->all(), $rules, $messages);

            if ($validator->fails()) {

                echo json_encode(["status" => FALSE, "errors" => $validator->errors()]);
            } else {

                if ($request->file("applicant_resume")) {

                    $resume_post = $request->except("_token");

                    $resume_file = $request->file("applicant_resume");
                    $original_name = $resume_file->getClientOriginalName();
                    $save_image_path = public_path() . '/storage/applicants/';
                    $resume_file->move($save_image_path, $original_name);
                    $resume_post["applicant_resume"] = $original_name;
                    $resume_post["created_date"] = $this->date_time;


                    $applicantObject = new RyapayApplicant();

                    $insert_status = $applicantObject->add_applicant($resume_post);

                    if ($insert_status) {
                        $message = ValidationMessage::$validation_messages["applicant_insert_success"];
                        echo json_encode(array("status" => TRUE, "message" => $message));
                    } else {
                        $message = ValidationMessage::$validation_messages["applicant_insert_failed"];
                        echo json_encode(array("status" => FALSE, "message" => $message));
                    }
                }
            }
        }
    }

    public function get_webhook_detail(Request $request)
    {
        echo "neopay";
    }

    public function demo_page(Request $request)
    {
        return view("demo")->with(["loadcss" => "contact", "page" => "request"]);
    }

    public function demo_request(Request $request)
    {


        $validator = Validator::make($request->all(), [
            "customer_email" => "required",
            "customer_amount" => "required|numeric|",
            "customer_mobile" => "required",
            "customer_username" => "required"
        ], [
            "customer_amount.min" => "Amount Should be atleast 1 rupee",
            "customer_amount.max" => "Amount Should not exceed",
            "customer_username.required" => "Usename field is required"
        ]);

        if ($validator->fails()) {
            return redirect()->back()->with("errors", $validator->errors());
        } else {

            $form_url = env('PROD_RUPAYAPAY_TEST');

            $paymentdetails = $request->except("_token");

            $custome = new Custom("test_merchantapi");
            $merchant_details = $custome->select_query(
                ["id", "api_key", "api_secret", "request_hashkey", "request_salt_key", "encryption_request_key", "response_salt_key", "encryption_response_key"],
                ["created_merchant" => 74]
            );

            if (!empty($merchant_details)) {

                $message = $merchant_details->api_key . $merchant_details->api_secret . "INR" . $request->customer_amount . $request->customer_email . $request->customer_mobile;

                $signature = hash_hmac('sha256', $message, $merchant_details->request_hashkey);

                $payment_details = [
                    "clientId" => $merchant_details->api_key,
                    "clientSecret" => $merchant_details->api_secret,
                    "txnCurr" => "INR",
                    "amount" => $request->customer_amount,
                    "emailId" => $request->customer_email,
                    "prodId" => "",
                    "mobileNumber" => $request->customer_mobile,
                    "signature" => $signature,
                    "username" => $paymentdetails["customer_username"],
                    "transaction_response" => $request->transaction_response,
                    "transaction_method_id" => $request->transaction_method_id,
                    "created_employee" => $request->created_employee
                ];

                $securedata = new RupayapaySecureData();
                $jsonObject = json_encode($payment_details);
                $encryption = $securedata->encrypt($jsonObject, $merchant_details->request_salt_key, $merchant_details->encryption_request_key);

                session(["response_salt_key" => $merchant_details->response_salt_key, "encryption_response_key" => $merchant_details->encryption_response_key]);

                return view('.linklayouts.requestpay')->with(["form_url" => $form_url, "merchant_details" => $merchant_details, "encryption" => $encryption]);
            } else {

                return redirect()->back()->with('no_api', "Contact your merchant");
            }
        }
    }

    public function payout_response(Request $request)
    {
        echo json_encode($request->all());
    }

    public function forgotpassword()
    {
        return view('forgotpassword');
    }

    public function loginform()
    {
        return view('loginform');
    }

    public function registerform()
    {
        return view('registerform');
    }

    public function viewlog()
    {
        $logFile = escapeshellarg(storage_path('logs/laravel.log'));

        $logarray = `tail -n 500 $logFile`;

        $logs = explode('[2022-', $logarray);

        $reversed =  array_reverse($logs);

        $newarr = [];

        foreach ($reversed as $key => $reverarr) {
            $newarr[$key] = explode('[stacktrace]', $reverarr);
        }

        return view('merchant.viewlogs', compact('newarr'));
    }
}
