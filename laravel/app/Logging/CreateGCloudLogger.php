<?php

namespace App\Logging;

use Google\Cloud\Logging\LoggingClient;
use Monolog\Handler\PsrHandler;
use Monolog\Logger;


class CreateGCloudLogger
{
    public function __invoke(array $config)
    {
        /* $logName = env('APP_NAME', 'Lumen'); */
        $logName = isset($config['logName']) ? $config['logName'] : 'treasury';
        $logging = new LoggingClient([
            'projectId' => env('GOOGLE_CLOUD_PROJECT_ID'),
            'keyFilePath' => storage_path("keys/gcp/service-key-". env('APP_ENV') .".json"),
        ]);
        $psrLogger = $logging->psrLogger($logName);

        $handler = new PsrHandler($psrLogger);
        return new Logger($logName, [$handler]);
    }
}