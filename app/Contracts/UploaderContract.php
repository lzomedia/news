<?php

namespace App\Contracts;

interface UploaderContract
{
    public function upload(string $filePath, string $fileName): void;
}
