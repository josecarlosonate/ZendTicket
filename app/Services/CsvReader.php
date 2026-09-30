<?php

namespace App\Services;

use RuntimeException;

class CsvReader
{
    public function read(string $path, array $expectedHeaders = []): array
    {
        if (! file_exists($path)) {
            throw new RuntimeException("CSV file not found: {$path}");
        }

        $file = fopen($path, 'r');

        if ($file === false) {
            throw new RuntimeException("Unable to open CSV file: {$path}");
        }

        $header = fgetcsv($file);

        if ($header === false) {
            fclose($file);

            throw new RuntimeException("CSV file is empty: {$path}");
        }

        if ($expectedHeaders !== [] && $header !== $expectedHeaders) {
            fclose($file);

            throw new RuntimeException(
                "CSV file has invalid headers: {$path}"
            );
        }

        $rows = [];
        $line = 1;
        while (($row = fgetcsv($file)) !== false) {
            $line++;
            if (count($header) !== count($row)) {
                fclose($file);

                throw new RuntimeException(
                    "CSV row has an invalid number of columns at line {$line}: {$path}"
                );
            }

            $rows[] = array_combine($header, $row);
        }

        fclose($file);

        return $rows;
    }
}
