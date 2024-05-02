<?php

namespace App\Services\Process;

use App\Services\BaseService;
use Gemini\Laravel\Facades\Gemini;
use GuzzleHttp\Client;
use Google_Client;
use Gemini\Data\Blob;
use Gemini\Enums\MimeType;
use Gemini\Enums\ModelType;
use App\Models\TunedModel;


class GeminiService extends BaseService
{
    private $repository;

    public function __construct()
    {
        $this->gemini_data = $this->getAccessToken();
        $this->client = new Client([
            'base_uri' => $this->gemini_data['base_uri'],
            'headers' => [
                'Authorization' => 'Bearer ' . $this->gemini_data['access_token'],
                'Content-Type' => 'application/json',
                'x-goog-user-project' => $this->gemini_data['project_id'],
            ],
        ]);
    }

    private function getAccessToken()
    {
        $credentials_path = storage_path('keys\gcp\service-key.json');
        $client = new Google_Client();
        $client->setAuthConfig($credentials_path);
        $client->setScopes([
            'https://www.googleapis.com/auth/cloud-platform',
            'https://www.googleapis.com/auth/generative-language.tuning',
        ]);

        $access_token = $client->fetchAccessTokenWithAssertion();

        $access_token = $access_token['access_token'];
        $project_id = 'hackathon-faq-ai';
        $base_uri = 'https://generativelanguage.googleapis.com';

        return compact('client','access_token', 'project_id', 'base_uri');
    }

    private function guzzleResponseFormatter($response)
    {
        return json_decode($response->getBody()->getContents(), true);

    }

    public function listModel()
    {
        return $this->executeFunction(function () {

            $response = $this->client->get('/v1beta/tunedModels');
            return $models = $this->guzzleResponseFormatter($response);

            $model_list = [];

            foreach ($models['tunedModels'] as $key => $model) {
                $to_remove = "tunedModels/";
                $model_name = str_replace($to_remove, '', $model['name']);

                $model_list[$key]['model_name'] = $model_name;
                $model_list[$key]['display_name'] = $model['displayName'];
            }

            return $model_list;
        });
    }

    public function chat($request)
    {
        $model = $request->model;
        $message = $request->message;
        $key = env('GEMINI_API_KEY');

        $response = $this->client->post('/v1beta/tunedModels/' . $model . ':generateContent', [
            'query' => [
                'key' => $key,
            ],
            'json' => [
                'contents' => [
                    [
                        'parts' => [
                            [
                                'text' => $message,
                            ],
                        ],
                    ],
                ],
            ],
        ]);
        $response = $this->guzzleResponseFormatter($response);

        return $this->executeFunction(function () use ($response) {
            return $response["candidates"][0]["content"]["parts"][0]["text"] ?? "There seems to be a problem with Gemini AI. Please Try again later";
        });

    }


    function createModel($request)
    {

        $gemini_data = $this->getAccessToken();
        $client = new Client();

        $postData = [
            'display_name' => 'Animal Model',
            'base_model' => 'models/gemini-1.0-pro-001',
            'tuning_task' => [
                'hyperparameters' => [
                    'batch_size' => 2,
                    'learning_rate' => 0.001,
                    'epoch_count' => 5,
                ],
                'training_data' => [
                    'examples' => [
                        'examples' => [
                            [
                                'text_input' => '1',
                                'output' => '2',
                            ],
                            [
                                'text_input' => '3',
                                'output' => '4',
                            ],
                            // Add more examples as needed
                        ]
                    ]
                ]
            ]
        ];
        $response = $this->client->post('/v1beta/tunedModels', [
            'json' => $postData,
        ]);

        return $this->guzzleResponseFormatter($response);
    }

    function showSystem($id)
    {
        return $this->executeFunction(function () use ($id) {
            return TunedModel::find($id);
        });

    }

    function listSystem()
    {
        return $this->executeFunction(function () {
            return TunedModel::get();
        });

    }

    function createSystem($request)
    {
        return $this->executeFunction(function () use ($request) {
            return TunedModel::create([
                "name" => $request->name,
                "tuned_model" => $request->tuned_model
            ]);
        });

    }
}
