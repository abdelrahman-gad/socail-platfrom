<?php

namespace App\Console\Commands;

use App\Mail\DailyRegisteredUsersReport;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;


class SendDailyRegisterdUsersReport extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:send-daily-registerd-users-report';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send Daily Registered Users Report';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $yesterday = now()->subDay(); // Get yesterday's date 

        $users = User::where('is_admin', 0)
                   ->whereDate('created_at', $yesterday)
                   ->get();

    
        $admin = User::where('is_admin', 1)->select('id','is_admin','name','email')->first();
        if(!isset($admin)) return;

        $adminEmail = $admin->email;

        Mail::to($adminEmail)->send(new DailyRegisteredUsersReport($users));    
        
    }
}
