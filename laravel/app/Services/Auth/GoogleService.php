<?php

namespace App\Services\Auth;

use App\Services\BaseService;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;
use Google_Client;

class GoogleService extends BaseService
{

    public function redirectToGoogle()
    {
        return Socialite::driver('google')
            ->stateless()
            ->with(
                [
                    "access_type" => "offline",
                    "prompt" => "consent select_account"
                ]
            )->redirectUrl(config('services.google.redirect'))
            ->redirect()
            ->getTargetUrl();
    }

    public function handleGoogleCallback($request)
    {
        $code = $request->code;
        $token =  Socialite::driver('google')->getAccessTokenResponse($code);

        if (!empty ($token['id_token'])){
            $client = new Google_Client(['client_id' => env('GOOGLE_CLIENT_ID')]);
            $user = $client->verifyIdToken($token['id_token']);
            $data = (object)$user;

            $google = [
                'email' => $data->email,
                'email_verified' => $data->email_verified,
                'profile_picture' => $data->picture,
            ];

            $success['google'] = $google;

            return view('auth.google-callback', ['data' => $success]);
        } else {
            return $this->requestError(401, 'Login', '', 401, 'Failed', 'Invalid Google Token');
        }
    }
}
