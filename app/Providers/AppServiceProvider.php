<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
    ];

    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', fn(User $user) => $user->isAdmin());
        Gate::define('curator', fn(User $user) => $user->isCurator());
        Gate::define('student', fn(User $user) => $user->isStudent());

        Gate::define('manage-students', function (User $user) {
            return $user->isAdmin() || $user->isCurator();
        });
    }
}