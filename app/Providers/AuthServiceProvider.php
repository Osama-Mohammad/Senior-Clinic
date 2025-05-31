<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Models\{Doctor, Patient, Admin, Secretary};
use App\Policies\{DoctorPolicy, PatientPolicy, AdminPolicy, SecretaryPolicy};

class AuthServiceProvider extends ServiceProvider
{
    protected $policies = [
        Doctor::class    => DoctorPolicy::class,
        Patient::class   => PatientPolicy::class,
        Admin::class     => AdminPolicy::class,
        Secretary::class => SecretaryPolicy::class,
    ];

    public function boot(): void
    {
        $this->registerPolicies();
    }
}
