<?php

namespace App\Providers;

use App\Models\Division;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('astor', function ($attribute, $value, $parameters, $validator) {
            $astor = data_get($validator->getData(), 'astor');

            $peran = Division::where('name', 'Peran')->first();

            if (!$astor) {
                return true;
            }
            if ($attribute === 'priority_division1') {
                return $value === $peran->id;
            }
            if ($attribute === 'priority_division2') {
                return $value === null;
            }
            return false;
        });
    }
}
