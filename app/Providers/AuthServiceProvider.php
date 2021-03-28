<?php

namespace App\Providers;

use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('admin', function ($user) {
            return $user->roles->pluck('name')->contains('Admin');
        });

        Gate::define('editor', function ($user) {
            return $user->roles->pluck('name')->contains('Editor');
        });

        Gate::define('owner', function ($user, $model) {
            return $user->id == $model->user_id;
        });

        Gate::define('ownerTime', function (?User $user, $model) {
            if ($model->created_at->addMinutes(30)->gt(now())) {
                return optional($user)->id == $model->user_id ??
                $model->cookie == request()->cookie('guestCookie');
            }
        });

    }
}
