@extends('layouts.reportstyle')

@section('report-content')
<body>
<div class="container">
    <div class="row justify-content-center" style="text-align: center;">
        <div class="col-md-12" style="text-align: center;">
            <div class="card text-center" style="text-align: center;">
                <div class="card-body align-content-center" style="text-align: center;">
                    <h2 class="card-title text-center">Your report is ready</h2>
                    <h1 class="text-center">
                        <svg style=
                             "filter: invert(39%) sepia(95%) saturate(1073%) hue-rotate(85deg) brightness(112%) contrast(82%);"
                             width="1em"
                             height="1em"
                             viewBox="0 0 16 16"
                             class="bi bi-check-circle"
                             xmlns="http://www.w3.org/2000/svg"
                        >
                            <path fill-rule="evenodd" d="M8 15A7 7 0 1 0 8 1a7 7 0 0 0 0 14zm0 1A8 8 0 1 0 8 0a8 8 0 0 0 0 16z"/>
                            <path fill-rule="evenodd" d="M10.97 4.97a.75.75 0 0 1 1.071 1.05l-3.992 4.99a.75.75 0 0 1-1.08.02L4.324 8.384a.75.75 0 1 1 1.06-1.06l2.094 2.093 3.473-4.425a.236.236 0 0 1 .02-.022z"/>
                        </svg>
                    </h1>
                    <p class="card-text text-center"> Your report <b> {{ $reportName }}.pdf </b> has been generated. </p>
                    <p class="card-text text-center"> You can find it in
                        <a href="{{ route('reports.index') }}" class="text-center">
                            Mercatodo Reports' Dashboard.
                        </a>
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
</body>
@endsection
