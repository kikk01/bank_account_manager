<?php

namespace App\Utils;

class CsvExtractorUtils
{
    private string $pathname;
    private string $mode;
    private string $delimiter;
    private int $length;

    public function __construct(string $pathname, ?string $mode = 'r+' , ?string $delimiter = ';', ?int $length = 1000)
    {
        $this->pathname = $pathname;
        $this->mode = $mode;
        $this->delimiter = $delimiter;
        $this->length = $length;
    }

    public function extract()
    {
        // serve to detect end line for mac file
        ini_set('auto_detect_line_endings', TRUE);

        $movements = [];
        if (($handle = fopen($this->pathname, $this->mode)) !== FALSE) {
            $isHeader = true;
            while(($rowOfData = fgetcsv($handle, $this->length, $this->delimiter)) !== FALSE) {
                if (!$isHeader) {
                    $movements[] = $rowOfData;
                }
                $isHeader = false;
            }
        }

        fclose($handle);
        ini_set('auto_detect_line_endings', FALSE);

        return $movements;
    }
}
