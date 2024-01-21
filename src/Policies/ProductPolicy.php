<?php

namespace Danial\SimpleMarketplace\Policies;

use App\Models\User;
use Danial\SimpleMarketplace\Models\Order;
use Danial\SimpleMarketplace\Models\Product;
use Illuminate\Auth\Access\HandlesAuthorization;

class ProductPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return $user->is_admin;
    }

    public function view(User $user, Product $product): bool
    {
        return $user->id === $product->user_id || $user->is_admin;
    }

    public function create(User $user): bool
    {
        return !$user->is_admin;
    }

    public function delete(User $user, Product $product): bool
    {
        return $user->id === $product->user_id || $user->is_admin;
    }
}
