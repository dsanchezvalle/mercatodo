<?php

namespace App\Mail;

use App\Report;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ReportGenerated extends Mailable
{
    use Queueable, SerializesModels;

    public $report;

    /**
     * Create a new message instance.
     *
     * @param Report $report
     */
    public function __construct(Report $report)
    {
        $this->report = $report;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(): ReportGenerated
    {
        return $this->from('admin@mercatodo.com')
            ->view('emails.reports.generated')
            ->with([
                'reportName' => $this->report->name,
            ]);
    }
}
