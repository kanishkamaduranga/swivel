<?php

namespace App\Providers;

use App\Repository\Organization\OrganizationInterface;
use App\Repository\Organization\OrganizationRepository;
use App\Repository\Ticket\TicketInterface;
use App\Repository\Ticket\TicketRepository;
use App\Repository\User\UserInterface;
use App\Repository\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind(OrganizationInterface::class, OrganizationRepository::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(TicketInterface::class, TicketRepository::class);
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
