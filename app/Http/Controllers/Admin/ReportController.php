<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\DateRangeRequest;
use App\Order;
use App\Report;

use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use phpDocumentor\Reflection\Types\Boolean;

class ReportController extends Controller
{

    private $startDate;
    private $endDate;

    /**
     * ReportController constructor.
     */
    public function __construct()
    {
        $this->authorizeResource(Report::class, 'report');
    }

    /**
     * Display a listing of the resource.
     *
     * @return void
     */
    public function index()
    {
        $reports = Report::all();
        return response()->view('admin.report.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param DateRangeRequest $request
     * @return RedirectResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function create(Request $request): RedirectResponse
    {
        if(!$this->validateDateRange($request)){
            return redirect('reports')->withErrors(['Invalid date range']);
        };

        $startDateWithTime = Carbon::createFromFormat('d/m/Y', $this->startDate)->setTimeFromTimeString('00:00:00');
        $endDateWithTime = Carbon::createFromFormat('d/m/Y', $this->endDate)->setTimeFromTimeString('23:59:59')->addMicroseconds(999999);

        if ($request->input('report_type') == '1'){
            $ordersInDateRange = Order::where('created_at', '>', $startDateWithTime)
                ->where('created_at', '<', $endDateWithTime)->get();
            dd($ordersInDateRange);

            Report::create(
                [
                    'name' => 'Sales_report_from_' . $this->startDate . '_to_' . $this->endDate,
                    'report_path' => $this->get_report_path(),
                    'user_id' => auth()->user()->id,
                ]
            );
            return redirect('reports')->with('success', 'Your report will be created.');
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified Report in storage.
     *
     * @param  Report $report
     * @return Response
     */
    public function show(Report $report): Response
    {
        Log::channel('single')->notice("User with ID " . auth()->user()->id . " has accessed to details for report with ID " . $report->id);
        return response()->view('reports', compact('report'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Report  $report
     * @return Response
     */
    public function edit(Report $report)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Report  $report
     * @return Response
     */
    public function update(Request $request, Report $report)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Report  $report
     * @return Response
     */
    public function destroy(Report $report)
    {
        //
    }

    protected function validateDateRange(Request $request): bool
    {
        $dateRange = $request->get('datefilter');
        $dateRegex = '/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4} - ([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/';
        if(!preg_match($dateRegex, $dateRange)) {
            return false;
        }

        $dates = array_map('trim', explode('-', $dateRange));
        $this->startDate = $dates[0];
        $this->endDate = $dates[1];
        $request->request->add([
            'start_date' => Carbon::createFromFormat('d/m/Y', $this->startDate)->format('m/d/Y'),
            'end_date' => Carbon::createFromFormat('d/m/Y', $this->endDate)->format('m/d/Y')
        ]);

        $validator = Validator::make($request->all(),[
            'datefilter' => [
                'required',
                'string',
                'regex:/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4} - ([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/'
            ],
            'start_date' => [
                'required',
                'date',
                'before_or_equal:today'
            ],
            'end_date' => [
                'required',
                'date',
                'after_or_equal:start_date',
                'before_or_equal:today'
            ]
        ])->validate();
        return true;
    }

    /**
     * @return string
     */
    protected function get_report_path(): string
    {
        $timeStamp = Carbon::now()->format('YmdHisu');
        $adminId = auth()->user()->id;
        $fileExtension = 'pdf';

        return '/reports/' . $timeStamp . '_' .  $adminId . '.' . $fileExtension;
    }
}
