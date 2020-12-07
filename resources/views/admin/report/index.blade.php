@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
          <div class="card">
              <div class="card-header h4">Reports' dashboard </div>
              <div class="card-body">
                    <form action="{{ route('reports.create') }}" method="GET">

                        <div class="form-group row form-inline">
                            <label class="ml-4 m-2" for="report_type">Select report:</label>
                            <select class="mr-5" name="report_type" id="report_type">
                                <option value="1">Orders report</option>
                            </select>
                            <div class="row">
                                <label class="mr-2 mt-0 mb-0 p-0" for="datefilter">Date range:</label>
                                <input class="mr-5 pt-0 pb-0" type="text" name="datefilter" value="" />
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
                            <button type="submit" class="btn btn-primary btn-sm mr-3">
                                {{ __('Generate Report') }}
                            </button>
                            <a href="{{ route('home') }}" class="btn btn-primary btn-sm">{{ __('Back') }}</a>
                        </div>

                        @if ($errors->any())
                            <div class="alert alert-danger row-md-4 row-md-offset-4 ml-3 p-2">
                                <ul class="ml-3 mb-0 p-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        @if(session()->has('message'))
                            <div class="alert alert-success row-md-4 row-md-offset-4 m-0 p-2">
                                {{ session()->get('message') }}
                            </div>
                            <br>
                        @endif

                        <table class="table table-striped table-hover">
                            <tr>
                                <th class="text-center">Report ID</th>
                                <th>Title</th>
                                <th class="text-center">Author</th>
                                <th class="text-center">Download</th>
                            </tr>
                            @if(count($reports)>0)
                                @foreach($reports as $report)
                                    <tr>
                                        <td class="text-center">{{ $report->id }}</td>
                                        <td class="text-wrap">
                                            <a href="{{ route('reports.show', $report) }}" target="_blank">
                                                {{ $report->name }}
                                            </a>
                                        </td>
                                        <td class="text-center">
                                            {{ $report->user->name . ' ' . $report->user->surname }}
                                        </td>
                                        <td class="text-center">
                                            <a href="{{ route('reports.download', $report) }}" class="btn btn-success btn-sm">
                                                <svg width="1em" height="1em" viewBox="0 0 16 16" class="bi bi-file-earmark-arrow-down" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M4 0h5.5v1H4a1 1 0 0 0-1 1v12a1 1 0 0 0 1 1h8a1 1 0 0 0 1-1V4.5h1V14a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V2a2 2 0 0 1 2-2z"/>
                                                    <path d="M9.5 3V0L14 4.5h-3A1.5 1.5 0 0 1 9.5 3z"/>
                                                    <path fill-rule="evenodd" d="M8 6a.5.5 0 0 1 .5.5v3.793l1.146-1.147a.5.5 0 0 1 .708.708l-2 2a.5.5 0 0 1-.708 0l-2-2a.5.5 0 1 1 .708-.708L7.5 10.293V6.5A.5.5 0 0 1 8 6z"/>
                                                </svg>
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <td class="alert-info" colspan="7" style="text-align: center">There are no reports to show.</td>
                            @endif
                        </table>
                        {{ $reports->links() }}
              </div>
          </div>
        </div>
    </div>
</div>

@endsection
