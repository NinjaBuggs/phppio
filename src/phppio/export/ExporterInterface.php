<?php
declare(strict_types=1);

namespace phppio\export;

interface ExporterInterface
{
    public function export(string $json): void;
}
