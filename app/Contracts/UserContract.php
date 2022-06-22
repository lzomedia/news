<?php
namespace App\Contracts;


interface UserContract
{
    public function getAllUsers(): array;

    public function getUserId(): int;
}
