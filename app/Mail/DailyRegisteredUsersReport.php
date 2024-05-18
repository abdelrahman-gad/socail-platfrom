<?php

namespace App\Mail;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Collection;

class DailyRegisteredUsersReport extends Mailable
{
    use Queueable, SerializesModels;

    public Collection $users;
    
    public function __construct(Collection $users)
    {

        $this->users = $users;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this
            ->subject('Daily Registered Users Report')
            ->view('mail.admin.daily-registered-users-report');
    }
}
