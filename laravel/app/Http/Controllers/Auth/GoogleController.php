<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Controllers\BaseController;
use App\Services\Auth\GoogleService;

class GoogleController extends BaseController
{
    private $service;

    public function __construct(GoogleService $service)
    {
        $this->service = $service;
    }

    public function redirectToGoogle()
    {
        return $this->service->redirectToGoogle();
    }

    public function handleGoogleCallback(Request $request)
    {
        return $this->service->handleGoogleCallback($request);
    }
}
