<?php

namespace App\Http\Controllers\Process;

use App\Http\Controllers\Controller;
use App\Services\Process\GeminiService;
use App\Http\Requests\Process\GeminiRequest;

class GeminiController extends Controller
{
    private $service;

    public function __construct(GeminiService $service)
    {
        $this->service = $service;
    }

    public function listModel()
    {
        return $this->service->listModel();
    }

    public function createModel(GeminiRequest $request)
    {
        return $this->service->createModel($request);
    }

    public function chat(GeminiRequest $request)
    {
        return $this->service->chat($request);
    }

    public function showSystem($id)
    {
        return $this->service->showSystem($id);
    }

    public function listSystem()
    {
        return $this->service->listSystem();
    }

    public function createSystem(GeminiRequest $request)
    {
        return $this->service->createSystem($request);
    }
}
