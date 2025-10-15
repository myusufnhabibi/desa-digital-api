<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            \App\Interfaces\UserRepositoryInterface::class,
            \App\Repositories\UserRepository::class
        );

        $this->app->bind(
            \App\Interfaces\HeadOfFamilyInterface::class,
            \App\Repositories\HeadOfFamilyRepository::class
        );

        $this->app->bind(
            \App\Interfaces\FamilyMemberInterface::class,
            \App\Repositories\FamilyMemberRepository::class
        );

        $this->app->bind(
            \App\Interfaces\SocialAssistanceInterface::class,
            \App\Repositories\SocialAssistanceRepositroy::class
        );

        $this->app->bind(
            \App\Interfaces\SocialAssistanceRecepientsInterface::class,
            \App\Repositories\SocialAssistanceRecepientsRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
