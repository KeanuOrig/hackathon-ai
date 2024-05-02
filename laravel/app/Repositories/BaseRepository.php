<?php

namespace App\Repositories;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Mail;
use App\Models\CsvUpload;

class BaseRepository
{
    private $csv_model;

    public function __construct(CsvUpload $csv_model)
    {
        $this->csv_model = $csv_model;
    }

    // Function for api response
    protected function petnetResponse($code, $message, $result = null, $httpCode = 200, $errorType = null, $errorMessage = null) {
        
        if ($httpCode === 200) {
            return response()->json(
                [
                    "code" => $code,
                    "message" => $message,
                    "data" => $result
                ],
                $httpCode
            );
        }

        return response()->json(
            [
                "code" => $code,
                "message" => $message,
                "data" => [
                    "type" => $errorType,
                    "message" => $errorMessage
                ]
            ],
            $httpCode
        );
    }

    // Execute function for saving data to table
    protected function executeFunction(callable $function)
    {
        try {
            DB::beginTransaction();
            $data = call_user_func($function);
            DB::commit();

            return $this->petnetResponse(200, 'Good', $data, 200, 'Good', null);
        } catch (\Throwable $th) {
            DB::rollback();
            return $this->petnetResponse(500, 'Failed', null, 500, 'DB', $th->getMessage());
        }
    }

    // Function for getting data from another api endpoint
    public function apiResponse($data)
    {
        switch($data['method']){
            case 'get':
                $response = Http::withHeaders([
                    'X-Perahub-Gateway-Token' => 'ca40285ce31f0e6633e3a27837de726c',
                    'Authorization' => 'Bearer' . ' ' . $data['token'],
                ])->get($data['link']);

                $response = json_decode($response->body(), true);
               
                return $response;
                break;

            case 'post':
                if(empty($data['token'])) {
                    $response = Http::withHeaders([
                        'X-Perahub-Gateway-Token' => 'ca40285ce31f0e6633e3a27837de726c',
                    ])->post($data['link'], array('email' => $data['email']));

                    $response = json_decode($response->body(), true);
                }
                return $response;
                break;
        }
    }

    // Try cactch function
    public function tryCatchWrapper($codeToExecute, $customTitle, $request = null, $id = null) 
    {
        try {
            return $codeToExecute($request, $id);
        } catch (\Throwable $th) {
            return $this->petnetResponse(500, 'An error occurred', null, 500, $customTitle, $th->getMessage());
        }
    }

    // Upload CSV function
    public function uploadCSV($data)
    {
        $result = $this->tryCatchWrapper(function($data) {    

            $import_id = $this->csv_model->create(['filename' => $data['filename'],'db_table' => $data['db_table'], 'edit_by' => $data['edit_by']]);
            return $import_id;

        }, "Upload CSV");

        return $result;
    }

    // Send Email with Attachment
    public function sendEmail($data)
    {
        $subject = $data['subject'] ?? "Web Treasury";
        $to_email = $data['to_email'] ?? [];
        $cc_email = $data['cc_email'] ?? [];
        $bcc_email = $data['bcc_email'] ?? [];
        $filename = $data['filename'] ?? null;
        $filename2 = $data['filename2'] ?? null;
        $file = $data['file'] ?? null;
        $file2 = $data['file2'] ?? null;
       
        try {
            
            return Mail::send($data['blade_file'], $data, function($message) use ($to_email, $cc_email, $bcc_email, $subject, $file, $filename, $file2, $filename2) {
                $message->to($to_email)
                    ->subject($subject)
                    ->cc($cc_email)
                    ->bcc($bcc_email);
    
                if ($file && $filename) {
                    $message->attachData($file, $filename);
                }

                if ($file2 && $filename2) {
                    $message->attachData($file2, $filename2);
                }
            });

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('Email sending failed: ' . $e->getMessage());
            return $e->getMessage();
        }
    }

    
    public function numberToWords($number)
    {
        $units = ['', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
        $teens = ['', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
        $tens = ['', 'ten', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
        $thousands = ['', 'thousand', 'million', 'billion', 'trillion'];

        $words = [];

        $numArr = str_split(strrev($number), 3);

        foreach ($numArr as $key => $value) {
            $value = (int) strrev($value);
            $unit = $thousands[$key];

            if ($value % 100 > 0) {
                if ($value % 100 < 10) {
                    $words[] = $units[$value % 100];
                } elseif ($value % 100 < 20) {
                    $words[] = $teens[$value % 10];
                } else {
                    $words[] = $tens[$value % 100 / 10] . ' ' . $units[$value % 10];
                }
            }

            if ($value >= 100) {
                $words[] = $units[$value / 100] . ' hundred';
            }

            if ($unit && $value) {
                $words[] = $unit;
            }
        }

        return implode(' ', array_reverse($words));
    }
}