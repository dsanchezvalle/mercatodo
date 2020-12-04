@extends('layouts.app')

@section('content')
    <div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
            <div class="card">

                <div class="card-header h4">{{__('Filters')}}</div>
                <div class="card-body">

                    <form action="{{ route('report.create') }}" method="POST">
                        @csrf
                        <div class="form-group row">
                            <div class="col-md-3">
                            <label for="report_type">Select report:</label>
                                <select name="report_type" id="report_type">
                                    <option value="1">Orders report</option>
                                </select>
                            </div>
                            <div class="col-md-5">

                            <label for="datefilter">Date range:</label>
                                    <input type="text" name="datefilter" value="" />


                                    <script type="text/javascript">
                                        $(function() {
                                            $('input[name="datefilter"]').daterangepicker({
                                                autoUpdateInput: false,
                                                locale: {
                                                    cancelLabel: 'Clear'
                                                }
                                            });

                                            $('input[name="datefilter"]').on('apply.daterangepicker', function(ev, picker) {
                                                $(this).val(picker.startDate.format('DD/MM/YYYY') + ' - ' + picker.endDate.format('DD/MM/YYYY'));
                                            });

                                            $('input[name="datefilter"]').on('cancel.daterangepicker', function(ev, picker) {
                                                $(this).val('');
                                            });

                                        });
                                    </script>
                            </div>



                            <div class="col-md-6">
                                <button type="submit" class="btn btn-primary btn-sm">
                                        {{ __('Generate Report') }}
                                </button>
                                    <a href="{{ route('home') }}" class="btn btn-primary btn-sm">{{ __('Back') }}</a>
                            </div>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger row-md-4 row-md-offset-4 m-0 p-2">
                                <ul class="ml-3 mb-0 p-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if(session()->has('success'))
                            <div class="alert alert-success row-md-4 row-md-offset-4 m-0 p-2">
                                {{ session()->get('success') }}
                            </div>
                        @endif

                </div>
            </div>

            <div class="card">
                <div class="card-header h4">Reports' dashboard </div>
                <div class="card-body">
                    @can('viewAny', \App\Report::class)

                        <div class="pb-4">
                            <a href="{{ route('reports.create') }}" class="btn btn-primary">Create New Report</a>
                            <a
                                class="btn btn-primary"
                                data-toggle="collapse"
                                href="#collapse1"
                                role="button"
                                aria-expanded="false"
                                aria-controls="collapse1"
                            >
                                Import books
                            </a>



                        </div>

                    @endcan
                    <table class="table table-striped table-hover">
                        <tr>
                            <th class="text-center">Report ID</th>
                            <th>Title</th>
                            <th>Author</th>
                            <th></th>
                        </tr>

                        @if(count($reports)>0)
                            @foreach($reports as $report)
                                <tr>
                                    <td class="text-center"><a href="{{ route('reports.show', $report) }}">{{ $report->id }} </a></td>
                                    <td>{{ $report->name }}</td>
                                    <td>{{ $report->user_id }}</td>
                                    <td><a href="">Export</a></td>
                                </tr>
                            @endforeach
                        @else
                            <td class="alert-info" colspan="7" style="text-align: center">There are no reports to show.</td>
                        @endif

                    </table>

                </div>
            </div>
        </div>
    </div>
</div>


@endsection
