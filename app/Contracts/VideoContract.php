<?php

namespace App\Contracts;

interface VideoContract
{
    public function generateVideo(mixed $article): void;
}
