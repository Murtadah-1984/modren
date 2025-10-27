<?php

namespace App\Events\Users;

class UserCreated
{
    public function __construct(public User $user) {}
}
