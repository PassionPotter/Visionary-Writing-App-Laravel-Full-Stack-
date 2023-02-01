<?php

namespace App\Jobs;

use Mail;
use App\Mail\sendAccountActivation;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class NotifyUsersForAccountActivation implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $user;
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new sendAccountActivation($this->user);
        // mail("testdeveloper69@gmail.com", "TEST", "message");
       Mail::to($this->user->email)->send($email);
        // if (Mail::failures()) {
        //     print_r(Mail::failures());
        // }
        // die("Sak");
    }
}
