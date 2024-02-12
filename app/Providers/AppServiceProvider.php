<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Validator;

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
        // validate without spaces
        Validator::extend('without_spaces', function($attr, $value){
            return preg_match('/^\S*$/u', $value);
        });
        Validator::replacer('without_spaces', function ($message, $attribute, $rule, $parameters) {
            $newMessage =  'The '. $attribute . ' cannot contain spaces.';
            return str_replace($message, $newMessage, $message);
        });

        // validate summernote required
        Validator::extend('summernote_required', function ($attr, $value) {
            return strip_tags(trim($value)) !== '';
        });
        Validator::replacer('summernote_required', function ($message, $attribute, $rule, $parameters) {
            $newMessage =  'The '. $attribute . ' field is required.';
            return str_replace($message, $newMessage, $message);
        });
    }
}
