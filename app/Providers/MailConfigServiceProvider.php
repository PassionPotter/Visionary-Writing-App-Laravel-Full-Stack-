<?php

namespace App\Providers;

use Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\ServiceProvider;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
            $mail = DB::table('smtpemail')->first();
            if ($mail) //checking if table is not empty
            {
                $config = array(
                    'driver'     => $mail->MAIL_DRIVER,
                    'host'       => $mail->MAIL_HOST,
                    'port'       => $mail->MAIL_PORT,
                    'from'       => array('address' => $mail->MAIL_FROM_ADDRESS, 'name' => 'Visionary Writings'),
                    'encryption' => 'ssl',
                    'username'   => $mail->MAIL_USERNAME,
                    'password'   => $mail->MAIL_PASSWORD,
                   // 'sendmail'   => '/usr/sbin/sendmail -bs',
                   // 'pretend'    => false,
                );
                Config::set('mail', $config);
            }
    }
}
