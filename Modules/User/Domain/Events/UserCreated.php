<?php

declare(strict_types=1);

namespace Modules\User\Domain\Events;

use App\Events\Users\User;

final class UserCreated
{
    public function __construct(public User $user) {}
}
