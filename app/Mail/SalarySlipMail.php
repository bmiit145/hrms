<?php

namespace App\Mail;

use App\Models\Admin;
use Illuminate\Mail\Mailable;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;

class SalarySlipMail extends Mailable
{
    use Queueable, SerializesModels;

    public $admin;
    public $pdf;

    public function __construct(Admin $admin, $pdf)
    {
        $this->admin = $admin;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject('Your Monthly Salary Slip')
                    ->view('emails.salary-slip-pdf')
                    ->attachData($this->pdf->output(), 'salary_slip.pdf', [
                        'mime' => 'application/pdf',
                    ]);
    }
}