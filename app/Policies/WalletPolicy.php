<?php

namespace App\Policies;

use App\User;
use App\Wallet;
use Illuminate\Auth\Access\HandlesAuthorization;

class WalletPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if the given wallet can be shown to the user.
     *
     * @param  \App\User  $user
     * @param  \App\Wallet  $wallet
     * @return bool
     */
    public function show(User $user, Wallet $wallet)
    {
        return $user->id === $wallet->user_id;
    }


}
