<hr/>
@php
    $running_year = config('running_session');
    $year = explode('-', $running_year);
    $days = cal_days_in_month(CAL_GREGORIAN, $data['month'], $year[0]);
    $monthName = date("F", mktime(0, 0, 0, $data['month'], 10));
@endphp
<div class="col-md-12">
    <div class="col-md-4 col-md-offset-4">
        <div class="card card_text">
            <div class="card-body text-center">
                <h3>Attendance Report</h3>
                <h4>Class : {{ $data['class_name'] }}</h4>
                <h4>Section : {{ $data['section_name'] }} </h4>
                <h4>Month : {{ $monthName }} </h4>
            </div>
        </div>
        <hr/>
    </div>
</div>
<div class="col-md-12 col-sm-12 table-responsive">
    <table id="manage_all" class="table table-collapse table-bordered table-hover">
        <thead>
        <tr>
            <th class="std_id">Code</th>
            <th class="std_name">Name</th>
            @for ($i = 1; $i <= $days; $i++)
                <th class="day">{{ $i }}</th>
            @endfor
        </tr>
        </thead>
        <tbody>
        @foreach($data['result'] as $row)
            <tr>
                <td>{{ $row->std_code }}</td>
                <td>{{ $row->std_name }}</td>
                @for ($i = 1; $i <= $days; $i++)
                    @php
                        $attendance_date = $year[0].'-'.$data['month'].'-'.$i;
                        $attend_status = \App\Models\Attendance::where('class_id', '=', $data['class_id'])
                                ->where('section_id', '=', $data['section_id'])
                                ->where('student_code', '=', $data['std_code'])
                                ->where('attendance_date', '=', $attendance_date)->first();
                    @endphp
                    @if($attend_status)
                        @if($attend_status['status']== 1)
                            <td><i class="fa fa-circle green"></i></td>
                        @elseif($attend_status['status']== 0)
                            <td><i class="fa fa-circle red"></i></td>
                        @elseif($attend_status['status']== 2)
                            <td><i class="fa fa-circle blue"></i></td>
                        @endif
                    @else
                        <td></td>
                    @endif
                @endfor
            </tr>
        @endforeach
        </tbody>
    </table>
</div>
<style>
    th, td {
        font-size: 12px;
    }

    .serial {
        width: 5%;
    }

    .std_id {
        width: 5%;
    }

    .std_name {
        width: 18%;
    }

    .green {
        color: #0aa124;
    }

    .red {
        color: #d71001;
    }

    .blue {
        color: #3c6db2;
    }
</style>


