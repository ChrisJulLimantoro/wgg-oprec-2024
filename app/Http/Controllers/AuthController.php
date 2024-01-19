<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Google_Client;
use Illuminate\Support\Facades\Http;
use App\Models\Admin;
use App\Models\Applicant;

class AuthController extends Controller
{
    private $googleClient;
    public function __construct() {
        $this->googleClient = new Google_Client();
        $this->googleClient->setRedirectUri(env('GOOGLE_REDIRECT', url("/processLogin")));
        $this->googleClient->setClientId(env('GOOGLE_CLIENT_ID'));
        $this->googleClient->setClientSecret(env('GOOGLE_CLIENT_SECRET'));
        $this->googleClient->addScope("email");
        $this->googleClient->addScope("profile");
    }

    /**
     * Main Login Section
     * Only have 1 role as Candidates
     * LESS AUTHORATIVE
     */

    function loginView()
    {
        $data['link'] = $this->googleClient->createAuthUrl();
        $data['error'] = session('error');
        $data['title'] = "Login Page";
        return view('main.login',$data);
    }

    public function loginPaksa($nrp,Request $request){
        if (parse_url(url()->current(), PHP_URL_HOST) == 'wgg.petra.ac.id' && env('APP_ENV') == 'production') {
            abort(404);
        }
        
        $nrp = strtolower($nrp);
        $request->session()->put('email', $nrp."@john.petra.ac.id");
        $request->session()->put('nrp',$nrp);
        $request->session()->put('name', $nrp);
        // check if it is an admin
        $admin = Admin::where('email',$nrp."@john.petra.ac.id")->with('division')->get();
        if($admin->count() > 0){
            $request->session()->put('admin_id',$admin->first()->id);
            $request->session()->put('division_id',$admin->first()->division_id);
            $request->session()->put('role',$admin->first()->division->slug);
            $request->session()->put('isAdmin',true);
            // Check applicant too
            $applicant = Applicant::where('email',$nrp."@john.petra.ac.id")->get();
            if($applicant->count() > 0){
                $request->session()->put('applicant_id',$applicant->first()->id);
            }
            return redirect()->intended(route('admin.dashboard'));
        }else{
            $request->session()->put('isAdmin',false);
            // check if it is a applicant
            $applicant = Applicant::where('email',$nrp."@john.petra.ac.id")->get();
            if($applicant->count() > 0){
                $request->session()->put('applicant_id',$applicant->first()->id);
                return redirect()->to(route('applicant.application-form'));
            }else{
                return redirect()->to(route('applicant.application-form'));
            }
        }
    }

    function login(Request $request) {
        // if ($request->getScheme() == 'https'|| $request->getScheme() == 'http') {
        //     if (!isset($request->code)) {
        //         return redirect()->to("/")->with('error', "Error Authentication!!");
        //     }
        //     $token = $this->googleClient->fetchAccessTokenWithAuthCode($request->code);
        //     $payload = $this->googleClient->verifyIdToken($token['id_token']);
        //     // dd($payload);
        //     if ($payload) {
        //         // dd($payload['email']);
        //         //check petra mail
        //         if(isset($payload['hd']) && str_ends_with($payload['hd'], "petra.ac.id")){
        //             //set session  
        //             $request->session()->put('email', $payload['email']);
        //             $request->session()->put('name', $payload['name']);
        //             // session untuk mahasiswa tanpa nrp maka dosen dan admin
        //             if(str_ends_with($payload['hd'], "john.petra.ac.id")){
        //                 $request->session()->put('nrp',substr($payload['email'],0,9));
        //             }
        //             // check if it is an admin
        //             $admin = Admin::where('email',strtolower($payload['email']))->with('division')->get();
        //             if($admin->count() > 0){
        //                 $request->session()->put('admin_id',$admin->first()->id);
        //                 $request->session()->put('division_id',$admin->first()->division_id);
        //                 $request->session()->put('role',$admin->first()->division->slug);
        //                 $request->session()->put('isAdmin',true);
        //                 // Check applicant too
        //                 $applicant = Applicant::where('email',strtolower($payload['email']))->get();
        //                 if($applicant->count() > 0){
        //                     $request->session()->put('applicant_id',$applicant->first()->id);
        //                 }
        //                 return redirect()->intended(route('admin.dashboard'));  
        //             }else{
        //                 $request->session()->put('isAdmin',false);
        //                 // check if it is a applicant
        //                 $applicant = Applicant::where('email',strtolower($payload['email']))->get();
        //                 if($applicant->count() > 0){
        //                     $request->session()->put('applicant_id',$applicant->first()->id);
        //                     return redirect()->to(route('applicant.application-form'));
        //                 }else{
        //                     return redirect()->to(route('applicant.application-form'));
        //                 }
        //             }
        //             // return;

        //         }else{
        //             // echo 'gagal salah email, bkn email petra';
        //             return redirect()->to(route('login'))->with('error', "Please Use Your @john.petra.ac.id email");
        //         }
        //     } else {
        //         // Invalid ID token
        //     }
        //     return;
        // }
        
        // dd($request->all());
        if ($request->g_csrf_token  != null) {
            // valid CSRF token
            // Handle the error here

            \Firebase\JWT\JWT::$leeway = 60;

            do {
                $attempt = 0;
                try {
                    //get the cretential from post sent by google
                    $id_token = $request->credential;

                    //verify the idtoken to convert to the data
                    $payload = $this->googleClient->verifyIdToken($id_token);
            
                    if ($payload) {
                        //check petra mail
                        if(isset($payload['hd']) && $payload['hd'] == "petra.ac.id"){
                            $request->session()->put('email', $payload['email']);
                            $request->session()->put('name', $payload['name']);
                            // session untuk mahasiswa tanpa nrp maka dosen dan admin
                            if(str_ends_with($payload['hd'], "john.petra.ac.id")){
                                $request->session()->put('nrp',substr($payload['email'],0,9));
                            }
                            // check if it is an admin
                            $admin = Admin::where('email',strtolower($payload['email']))->with('division')->get();
                            if($admin->count() > 0){
                                $request->session()->put('admin_id',$admin->first()->id);
                                $request->session()->put('division_id',$admin->first()->division_id);
                                $request->session()->put('role',$admin->first()->division->slug);
                                $request->session()->put('isAdmin',true);
                                // Check applicant too
                                $applicant = Applicant::where('email',strtolower($payload['email']))->get();
                                if($applicant->count() > 0){
                                    $request->session()->put('applicant_id',$applicant->first()->id);
                                }
                                return redirect()->intended(route('admin.dashboard'));  
                            }else{
                                $request->session()->put('isAdmin',false);
                                // check if it is a applicant
                                $applicant = Applicant::where('email',strtolower($payload['email']))->get();
                                if($applicant->count() > 0){
                                    $request->session()->put('applicant_id',$applicant->first()->id);
                                    return redirect()->to(route('applicant.application-form'));
                                }else{
                                    return redirect()->to(route('applicant.application-form'));
                                }
                            }
                        }else{
                            return redirect()->to(route('login'))->with('error', "Please Use Your @john.petra.ac.id email");
                        }
                    } else {
                        // Invalid ID token
                        redirect()->to('/login')->with('error', "Error Authentication!!");
                    }

                    $retry = false;

                } catch (\Firebase\JWT\BeforeValidException $e) {
                    $attempt++;
                    $retry = $attempt < 2;
                }
            } while ($retry);
            
        } else {
            return redirect()->to("/login")->with('error', "Error CSRF");
        }
    }
    function logout(Request $request) {
        $request->session()->flush();
        return redirect()->to("/");
    }
}
