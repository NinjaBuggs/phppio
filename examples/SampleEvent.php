<?php
declare(strict_types=1);

namespace examples;

require_once("../../vendor/autoload.php");

use phppio\EventClient;
use phppio\PredictionIOException;

try {
    /**
     * Check Event Server status
     */
    $client = new EventClient(
        "uRnzQnUf4DbU50IWJQSdxmyckiSFZ7eUR1MJFix5O3yjmnJOqBN8TKxIKYxhVHE3");
    $response = $client->getStatus();
    echo($response);

    /**
     * Set user with event time
     */
    $response = $client->setUser(9, array('age' => 10),
        '2014-01-01T10:20:30.400+08:00');
    print_r($response);

    /**
     * Set user
     */
    $response = $client->setUser(8, array('age' => 20, 'gender' => 'M'), new \DateTime());
    print_r($response);

    /**
     * Unset user
     */
    $response = $client->unsetUser(8, array('age' => 20), new \DateTime());
    print_r($response);

    /**
     * Delete user
     */
    $response = $client->deleteUser(9, new \DateTime());
    print_r($response);

    /**
     * Set item with event time
     */
    $response = $client->setItem(3, array('itypes' => array('1')),
        '2013-12-20T05:15:25.350+08:00');
    print_r($response);

    /**
     * Set item
     */
    $response = $client->setItem(2, array('itypes' => array('1')), new \DateTime());
    print_r($response);

    /**
     * Unset item
     */
    $response = $client->unsetItem(2, array('itypes' => array('1')), new \DateTime());
    print_r($response);

    /**
     * Delete item
     */
    $response = $client->deleteItem(3, '2000-01-01T01:01:01.001+01:00');
    print_r($response);

    /**
     * Record user action on item
     */
    $response = $client->recordUserActionOnItem('view', 8, 2, new \DateTime());
    print_r($response);

    /**
     * Create event
     */
    $response = $client->createEvent(array(
        'event' => 'my_event',
        'entityType' => 'user',
        'entityId' => '8',
        'properties' => array('prop1' => 1, 'prop2' => 2),
    ));
    print_r($response);

    /**
     * Get event
     */
    $response = $client->getEvent('U_7eotSbeeK0BwshqEfRFAAAAUm-8gOyjP3FR73aBFo');
    print_r($response);
} catch (PredictionIOException $e) {
    echo $e->getMessage();
}
