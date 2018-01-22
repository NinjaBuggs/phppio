<?php
declare(strict_types=1);

namespace phppio\export;

/**
 * Class FileExporter writes events to a series of JSON objects in a file for batch import.
 */
class FileExporter extends BaseExporter implements ExporterInterface
{
    private $file;
    private $fileName;

    public function __construct(string $fileName)
    {
        $this->fileName = $fileName;
    }

    public function export(string $json): void
    {
        $this->file = fopen($this->fileName, 'wb');
        fwrite($this->file, "$json\n");
        fclose($this->file);
    }
}
