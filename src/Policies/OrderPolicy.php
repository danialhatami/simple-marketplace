<?php

namespace Danial\SimpleMarketplace\Policies;

use App\Models\User;
use Danial\SimpleMarketplace\Models\Order;
use Illuminate\Auth\Access\HandlesAuthorization;

class OrderPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->is_admin;
    }

    public function view(User $user, Order $order): bool
    {
        return $user->id === $order->user_id || $user->is_admin;
    }

    public function create(User $user): bool
    {
        return !$user->is_admin;
    }
}
