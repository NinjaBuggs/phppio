<?php
declare(strict_types=1);

namespace phppio;

/**
 * Client for an Event Server
 */
class EventClient extends BaseClient
{
    const DATE_TIME_FORMAT = \DateTime::ATOM;
    private $accessKey;
    private $eventUrl;

    public function __construct(
        string $accessKey,
        string $baseUrl = 'http://localhost:7070',
        float $timeout = 0,
        float $connectTimeout = 5
    ) {
        parent::__construct($baseUrl, $timeout, $connectTimeout);

        $this->accessKey = $accessKey;
        $this->eventUrl = sprintf("/events.json?accessKey=%s", $accessKey);
    }

    /**
     * $eventTime Time of the event in ISO 8601 format
     *               (e.g. 2014-09-09T16:17:42.937-08:00).
     *               Default is the current time.
     *
     * @throws PredictionIOException Request error
     */
    public function setUser(string $uid, array $properties = array(), ?string $eventTime): array
    {
        $eventTime = $this->getEventTime($eventTime);

        $data = [
            'event' => '$set',
            'entityType' => 'user',
            'entityId' => $uid,
            'properties' => (object) $properties,
            'eventTime' => $eventTime,
        ];

        return $this->sendRequest(BaseClient::POST, $this->eventUrl, $data);
    }

    /**
     * @throws PredictionIOException Request error
     */
    public function unsetUser(string $uid, array $properties, ?string $eventTime): array
    {
        if (empty($properties)) {
            throw new PredictionIOException('Properties should be provided');
        }

        $eventTime = $this->getEventTime($eventTime);

        $data = [
            'event' => '$unset',
            'entityType' => 'user',
            'entityId' => $uid,
            'properties' => $properties,
            'eventTime' => $eventTime,
        ];

        return $this->sendRequest(BaseClient::POST, $this->eventUrl, $data);
    }

    /**
     * @throws PredictionIOException
     */
    public function deleteUser(string $uid, ?string $eventTime): array
    {
        $eventTime = $this->getEventTime($eventTime);

        $data = [
            'event' => '$delete',
            'entityType' => 'user',
            'entityId' => $uid,
            'eventTime' => $eventTime,
        ];

        return $this->sendRequest('POST', $this->eventUrl, $data);
    }

    /**
     * @throws PredictionIOException Request error
     */
    public function setItem(string $iid, array $properties = array(), ?string $eventTime): array
    {
        $eventTime = $this->getEventTime($eventTime);

        $data = [
            'event' => '$set',
            'entityType' => 'item',
            'entityId' => $iid,
            'properties' => (object) $properties,
            'eventTime' => $eventTime,
        ];

        return $this->sendRequest(BaseClient::POST, $this->eventUrl, $data);
    }

    /**
     * Unset an item entity
     *
     * @param int|string Item Id
     * @param array Properties of the item entity to unset
     * @param string Time of the event in ISO 8601 format
     *               (e.g. 2014-09-09T16:17:42.937-08:00).
     *               Default is the current time.
     *
     * @return string JSON response
     *
     * @throws PredictionIOException Request error
     */
    public function unsetItem(string $iid, array $properties, ?string $eventTime): array
    {
        $eventTime = $this->getEventTime($eventTime);

        if (empty($properties)) {
            throw new PredictionIOException('Properties should be provided');
        }

        $data = [
            'event' => '$unset',
            'entityType' => 'item',
            'entityId' => $iid,
            'properties' => $properties,
            'eventTime' => $eventTime,
        ];

        return $this->sendRequest(BaseClient::POST, $this->eventUrl, $data);
    }

    /**
     * @throws PredictionIOException Request error
     */
    public function deleteItem(string $iid, ?string $eventTime): array
    {
        $eventTime = $this->getEventTime($eventTime);

        $data = [
            'event' => '$delete',
            'entityType' => 'item',
            'entityId' => $iid,
            'eventTime' => $eventTime,
        ];

        return $this->sendRequest(BaseClient::POST, $this->eventUrl, $data);
    }

    /**
     * @throws PredictionIOException Request error
     */
    public function recordUserActionOnItem(
        string $event,
        string $uid,
        string $iid,
        array $properties = array(),
        ?string $eventTime
    ): array {
        $eventTime = $this->getEventTime($eventTime);

        $data = [
            'event' => $event,
            'entityType' => 'user',
            'entityId' => $uid,
            'targetEntityType' => 'item',
            'targetEntityId' => $iid,
            'properties' => (object) $properties,
            'eventTime' => $eventTime,
        ];

        return $this->sendRequest(BaseClient::POST, $this->eventUrl, $data);
    }

    /**
     * @throws PredictionIOException Request error
     */
    public function createEvent(array $data): array
    {
        return $this->sendRequest('POST', $this->eventUrl, $data);
    }

    /**
     * @throws PredictionIOException Request error
     */
    public function getEvent(string $eventId): array
    {
        return $this->sendRequest(
            BaseClient::GET,
            sprintf("/events/%s.json?accessKey=%s", $eventId, $this->accessKey),
            []
        );
    }

    private function getEventTime(? string $eventTime): string
    {
        if ($eventTime) {
            return $eventTime;
        }

        return (new \DateTime())->format(self::DATE_TIME_FORMAT);
    }
}
