<?php
require __DIR__ . '/vendor/autoload.php';

use App\RequestBuilder;

$baseUrl = $_SERVER['BASE_URL'];
$batchSize = (int)$_SERVER['BATCH_SIZE'];

try {
    $requests = new RequestBuilder()->build($baseUrl, $batchSize);
    $nbOfRequests = 0;
    $timeStart = microtime(true);
    foreach ($requests as $content) {
        $nbOfRequests++;
        echo "Response from API root: " . $content . PHP_EOL;
        echo "-------------------------------------------" . PHP_EOL;
    }
} catch (\Exception $e) {
//    echo "Error: " . $e->getMessage() . PHP_EOL;
}
$time = floor(1000 * (microtime(true) - $timeStart));
echo "batch size $batchSize" . PHP_EOL;
echo "nombre de requêtes $nbOfRequests" . PHP_EOL;
echo "temps d'exécution des requêtes: $time ms" . PHP_EOL;

