<?php

namespace App\Policies;

use App\Models\Capsule;
use App\Models\User;

class CapsulePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the capsule overview.
     */
    public function view(User $user, Capsule $capsule): bool
    {
        return $capsule->user_id === $user->id;
    }

    /**
     * Determine whether the user can reveal/read the actual capsule message and secret contents.
     * Enforces the critical security rule on the server side: open_at must have arrived!
     */
    public function reveal(User $user, Capsule $capsule): bool
    {
        return $capsule->user_id === $user->id && $capsule->isReadyToOpen();
    }

    /**
     * Determine whether the user can update the model.
     * Editing is strictly forbidden once created: capsules are sealed forever until opened or deleted.
     */
    public function update(User $user, Capsule $capsule): bool
    {
        return false;
    }

    /**
     * Determine whether the user can delete the model.
     * Allowed only before capsule has opened.
     */
    public function delete(User $user, Capsule $capsule): bool
    {
        return $capsule->user_id === $user->id && $capsule->canBeDeleted();
    }

    /**
     * Determine whether the user can trigger opening the capsule.
     */
    public function open(User $user, Capsule $capsule): bool
    {
        return $capsule->user_id === $user->id && $capsule->isReadyToOpen();
    }
}
