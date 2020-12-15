<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Jobs\GenerateReport;
use App\Report;
use App\User;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class ReportController extends Controller
{

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
     * @return Response
     */
    public function index(): Response
    {
        $reports = Report::query()
            ->addSelect([
                'user_name' => User::select(DB::raw("CONCAT(name , ' ' , surname) as name"))
                ->whereColumn('reports.user_id', 'id')
                ->limit(1)
            ])
            ->paginate(config('view.paginate'));

        return response()->view('admin.report.index', compact('reports'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return Application|RedirectResponse|Redirector
     */
    public function create(Request $request)
    {
        if (!$this->validateDateRange($request)) {
            return redirect('reports')->withErrors(['Invalid date range']);
        };

        GenerateReport::dispatch($request->all(), auth()->user()->id, auth()->user()->email);

        return redirect('reports')->with('message', 'Your report is being generated. You will receive an email once it is ready.');
    }

    /**
     * Display the specified Report in storage.
     *
     * @param  Report $report
     * @return BinaryFileResponse
     */
    public function show(Report $report): BinaryFileResponse
    {
        Log::channel('single')->notice("User with ID " . auth()->user()->id . " has accessed to report with ID " . $report->id);

        return response()->file(storage_path() . $report->report_path);
    }

    /**
     * Download the specified Report.
     *
     * @param  Report $report
     * @return BinaryFileResponse
     */

    public function download(Report $report): BinaryFileResponse
    {
        Log::channel('single')->notice("User with ID " . auth()->user()->id . " has downloaded report with ID " . $report->id);

        return response()->download(storage_path() . $report->report_path, $report->name . '.pdf');
    }

    /**
     * Validate the given date range.
     *
     * @param Request $request
     * @return bool
     * @throws ValidationException
     */

    protected function validateDateRange(Request $request): bool
    {
        $dateRange = $request->get('datefilter');
        $dateRegex = '/^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4} - ([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/';
        if (!preg_match($dateRegex, $dateRange)) {
            return false;
        }

        $dates = array_map('trim', explode('-', $dateRange));
        $startDate = $dates[0];
        $endDate = $dates[1];

        $request->request->add([
            'start_date' => Carbon::createFromFormat('d/m/Y', $startDate)->format('m/d/Y'),
            'end_date' => Carbon::createFromFormat('d/m/Y', $endDate)->format('m/d/Y')
        ]);

        $validator = Validator::make($request->all(), [
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
                'before_or_equal:today',
            ]
        ])->validate();

        return true;
    }
}
