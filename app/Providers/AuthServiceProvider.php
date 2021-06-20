<?php

namespace App\Providers;

use App\Policies\PhoneNumber;
use App\Policies\PhoneNumberPolicy;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
         'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('view-phone-number', [PhoneNumberPolicy::class, 'view']);
        Gate::define('update-phone-number', [PhoneNumberPolicy::class, 'update']);
        Gate::define('delete-phone-number', [PhoneNumberPolicy::class, 'delete']);
        Gate::define('share-phone-number', [PhoneNumberPolicy::class, 'share']);
    }
}
