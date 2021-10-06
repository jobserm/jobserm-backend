<?php

namespace App\Providers;


use App\Models\Job;
use App\Models\User;
use App\Policies\JobPolicy;
use App\Models\Review;
use App\Policies\ReviewPolicy;
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
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
        Job::class => JobPolicy::class,

        Review::class => ReviewPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

//        Gate::define('update-job',function (User $user,Job $job){
//            return $user->isRole('EMPLOYER');
//        });
//
//        Gate::define('create-job',function (User $user){
//            return $user->isRole('EMPLOYER');
//        });
//
//        Gate::define('delete-job',function (User $user,Job $job){
//            return $user->isRole('ADMIN') or $user->id === $job->user_id or $user->isRole('EMPLOYER');
//        });
    }
}
