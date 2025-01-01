<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AdminLeaveStatusUpdate extends Mailable
{
    use SerializesModels;

    public $leaveData;

    // Constructor to pass leave data to the email
    public function __construct($leaveData)
    {
        $this->leaveData = $leaveData;
    }

    // Build the message
    public function build()
    {
        return $this->subject('Leave Status Update')
                    ->view('emails.admin_leave_status')
                    ->with([
                        'leaveData' => $this->leaveData,
                    ]);
    }
}
