<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Auth;
use App\User;
class viewComposer extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            ['admin.chapters.index',
            'admin.index',
            'admin.chapters.create',
            'admin.chapters.show',
            'admin.chapters.edit',
            'admin.books.create',
            'admin.books.index',
            'admin.books.draft',
            'admin.books.edit',
            'admin.books.trashed',
            'admin.users.index',
            'admin.users.create',
            'admin.users.profile',
            'admin.ads.index',
            'admin.ads.create',
            'admin.ads.edit',
            'admin.users.registered',
            'admin.payment.paymentform',
            'admin.payment.paymentdetails',
            'admin.payment.monthly',
            'admin.payment.addbank',
            'admin.payment.editbank',
            'admin.payment.bankdetails',
            'admin.comments.index',
            'admin.comments.edit',
            'admin.comments.reply',
        
        ],function($view){

             $view->with('user_profile',Auth::user()->profile);

        });
    }

    /**
     * Register services.
     *
     * @return void
     */ 
    public function register()
    {
        //
    }
}
