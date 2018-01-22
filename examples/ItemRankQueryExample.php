<?php
declare(strict_types=1);

namespace examples;

use phppio\EngineClient;

require_once("../../vendor/autoload.php");

/**
 * Get engine instance status
 */
$client = new EngineClient();
$response = $client->getStatus();
echo $response;

/**
 * Rank item 1 to 5 for each user
 */
for ($i = 1; $i <= 10; $i++) {
    $response = $client->sendQuery(array('uid' => $i, 'iids' => array(1, 2, 3, 4, 5)));
    print_r($response);
}
