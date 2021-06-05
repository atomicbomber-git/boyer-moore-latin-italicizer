<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    const CAN_ACT_AS_ADMIN = "CAN_ACT_AS_ADMIN";
    const CAN_ACT_AS_MAHASISWA = "CAN_ACT_AS_MAHASISWA";

    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define(self::CAN_ACT_AS_ADMIN, function (User $user) {
            return in_array($user->level, [User::LEVEL_ADMIN]);
        });

        Gate::define(self::CAN_ACT_AS_MAHASISWA, function (User $user) {
            return in_array($user->level, [User::LEVEL_MAHASISWA]);
        });
    }
}
