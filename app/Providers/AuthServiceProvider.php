<?php

namespace App\Providers;

use App\Services\FrontendService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        ResetPassword::createUrlUsing(function (object $notifiable, string $token) {
            return (new FrontendService)->create("auth/password-reset?token=$token&email={$notifiable->getEmailForPasswordReset()}");
        });

        VerifyEmail::createUrlUsing(function ($notifiable) {
            $token = sha1($notifiable->getEmailForVerification());

            return (new FrontendService)->create("auth/verify?id={$notifiable->getKey()}&token={$token}");
        });

        //
    }
}
