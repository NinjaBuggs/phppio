<?php
declare(strict_types=1);

namespace examples;

use phppio\EventClient;

require_once("../../vendor/autoload.php");

/**
 * Check event server status
 */
$client = new EventClient("uRnzQnUf4DbU50IWJQSdxmyckiSFZ7eUR1MJFix5O3yjmnJOqBN8TKxIKYxhVHE3");
$response = $client->getStatus();
echo($response);

/**
 * User generation example
 */
for ($u = 1; $u <= 10; $u++) {
    $response = $client->setUser($u, array('age' => 20 + $u, 'gender' => 'M'), new \DateTime());
    print_r($response);
}

/**
 * Item generation example
 */
for ($i = 1; $i <= 50; $i++) {
    $response = $client->setItem($i, array('itypes' => array('1')), new \DateTime());
    print_r($response);
}

/**
 * Event generation example
 */
for ($u = 1; $u <= 10; $u++) {
    for ($count = 0; $count < 10; $count++) {
        $i = mt_rand(1, 50);
        $response = $client->recordUserActionOnItem('view', $u, $i, new \DateTime());
        print_r($response);
    }
}
