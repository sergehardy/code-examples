<?php
require __DIR__ . '/vendor/autoload.php';

use App\RequestBuilder;

$baseUrl = $_SERVER['BASE_URL'];

try {
    $batchSize = null;
    $requests = new RequestBuilder()->build($baseUrl);
    $nbOfRequests = 0;
    $timeStart = microtime(true);
    foreach ($requests as $content) {
        $nbOfRequests++;
        error_log(sprintf("Response from API root: %s", $content));
    }
} catch (\Exception $e) {
    error_log(sprintf("Error: %s", $e->getMessage()));
}
$time = floor(1000 * (microtime(true) - $timeStart));
error_log(sprintf("batch size %d", $batchSize));
error_log(sprintf("number of requests %d", $nbOfRequests));
error_log(sprintf("total execution time: %d ms", $time));

