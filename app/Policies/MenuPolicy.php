<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Menu;
use Illuminate\Auth\Access\HandlesAuthorization;

class MenuPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can delete the menu.
     *
     * @param  \App\Models\User  $user
     * @param  \App\Models\Menu  $menu
     * @return bool
     */
    public function delete(User $user, Menu $menu)
    {
        return $user->id === $menu->merchant_id;
    }
    public function update(User $user, Menu $menu)
    {
        return $user->id === $menu->merchant_id;
    }
}
