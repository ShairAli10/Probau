<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

class CleanStringValidationProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
        Validator::extend('clean_string',function($attribute,$value,$parameters,$validator){
          if($value !== strip_tags($value)){
            return false;
          }
          return true;
        },'The :attribute contains disallowed charaters.'
    );
    }
}
