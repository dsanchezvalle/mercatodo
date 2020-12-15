<?php

namespace App\Jobs;

use App\Mail\ReportGenerated;
use App\Order;
use App\Report;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Barryvdh\Snappy\Facades\SnappyPdf as PDF;

class GenerateReport implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public $request;
    private $startDate;
    private $endDate;
    private $ordersPaymentStatusResume = [];
    private $authorId;
    private $authorEmail;

    /**
     * Create a new job instance.
     *
     * @param array $request
     * @param $userId
     * @param $userEmail
     */
    public function __construct(array $request, $userId, $userEmail)
    {
        $this->request = $request;
        $this->authorId = $userId;
        $this->authorEmail = $userEmail;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $rawFromDate = Carbon::createFromFormat('m/d/Y', $this->request['start_date']);
        $rawToDate = Carbon::createFromFormat('m/d/Y', $this->request['end_date']);

        if ($this->request['report_type'] == '1') {
            $fromDate = $rawFromDate->setTimeFromTimeString('00:00:00');
            $toDate = $rawToDate->setTimeFromTimeString('23:59:59')->addMicroseconds(999999);

            $orders = Order::where('created_at', '>', $fromDate)
                ->where('created_at', '<', $toDate)
                ->where('status', 'closed')
                ->get();

            $paymentStatusColumn = array_column($orders->toArray(), 'payment_status');

            foreach (array_count_values($paymentStatusColumn) as $payment_status => $occurrences) {
                $this->ordersPaymentStatusResume[$payment_status] = $occurrences;
            }
        }

        $reportPath = $this->getReportPath();
        $fromDate = $rawFromDate->format('d-m-Y');
        $toDate = $rawToDate->format('d-m-Y');
        $pdf = PDF::loadView(
            'admin.report.order',
            [
                'orders' => $orders,
                'ordersStatusResume' => $this->ordersPaymentStatusResume,
                'fromDate' => $fromDate,
                'toDate' => $toDate
            ]
        );

        $report = Report::create(
            [
                'name' => 'Orders_Report_(' . $fromDate . '_to_' . $toDate . ')',
                'report_path' => $reportPath,
                'user_id' => $this->authorId,
            ]
        );
        $pdf->save(storage_path($reportPath));
        Mail::to($this->authorEmail)->send(new ReportGenerated($report));
    }

    /**
     * @return string
     */
    protected function getReportPath(): string
    {
        $timeStamp = Carbon::now()->format('YmdHisu');
        $adminId = $this->authorId;
        $fileExtension = 'pdf';

        return '/app/reports/' . $timeStamp . '_' .  $adminId . '.' . $fileExtension;
    }
}
