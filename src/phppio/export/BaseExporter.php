<?php
declare(strict_types=1);

namespace phppio\export;

class BaseExporter
{
    public function createEvent(
        string $event,
        string $entityType,
        string $entityId,
        \DateTime $eventTime,
        ?string $targetEntityType,
        ?string $targetEntityId,
        ?array $properties
    ): void {

        $data = [
            'event' => $event,
            'entityType' => $entityType,
            'entityId' => $entityId,
            'eventTime' => $eventTime->format(\DateTime::ATOM),
        ];

        if (isset($targetEntityType)) {
            $data['targetEntityType'] = $targetEntityType;
        }

        if (isset($targetEntityId)) {
            $data['targetEntityId'] = $targetEntityId;
        }

        if (isset($properties)) {
            $data['properties'] = $properties;
        }

        $this->export(json_encode($data);
    }
}