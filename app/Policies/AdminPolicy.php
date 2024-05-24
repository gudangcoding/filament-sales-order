<?php

namespace App\Policies;

use App\Models\User;
use Filament\Resources\Resource;
use Illuminate\Auth\Access\AuthorizationContext;

class AdminPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function canManageResource(AuthorizationContext $context, Resource $resource): bool
    {
        return $context->user()->is_admin || $context->user()->is_super_admin;
    }
}
