<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Log;

class LogAfterRequest {

    public function handle($request, \Closure  $next)
    {
        return $next($request);
    }

    public function terminate($request, $response)
    {
        $daily_log = app('Psr\Log\LoggerInterface')->channel(env('LOG_CHANNEL', 'googlecloud'));

        $log = [
            'STATUS' => $response->status(),
            'URI' => $request->getUri(),
            'METHOD' => $request->getMethod(),
            'REQUEST' => $this->truncateRequestString($request, 10000),
            'RESPONSE' => $this->truncateResponseString($response, 10000)
        ];

        $log = json_encode($log, JSON_UNESCAPED_SLASHES);

        if ($response->status() == 200 || $response->status() == 400){
            $daily_log->info($log);
        } else {
            $daily_log->warning($log);
        }

    }

    private function truncateString($string, $maxLength)
    {
        $string = (string) $string;
    
        if (strlen($string) > $maxLength) {
            $string = substr($string, 0, $maxLength) . '...';
        }
    
        return $string;
    }
    
    private function truncateRequestString($request, $maxLength)
    {
        return strlen($request->getContent()) > $maxLength ? $this->truncateString($request->getContent(), $maxLength) : $request->all();
    }
    
    private function truncateResponseString($response, $maxLength)
    {
        return strlen($response->getContent()) > $maxLength ? $this->truncateString($response->getContent(), $maxLength) : $response;
    }
}