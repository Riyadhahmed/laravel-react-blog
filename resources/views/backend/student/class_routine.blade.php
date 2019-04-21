@extends('backend.layouts.student_master')
@section('title', 'Dashboard')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <p class="panel-title"> Class Routine</p>
                </div>
                <div class="box-body">
                    @if (session('status'))
                        <div class="alert alert-success">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="col-md-12" id="class_routine">
                        <div class="row" id="header_details">
                            <div class="col-md-4 col-sm-12 col-md-offset-4">
                                <p style="text-transform: uppercase; font-size: 14px; font-weight: bold; text-align: center">
                                    {{ $app_settings ? $app_settings->name : '' }} <br/>
                                    <strong>Class : </strong> {{ $data['class_name'] }} <br/>
                                    <strong>Section : </strong> {{ $data['section_name'] }} <br/>
                                </p>
                            </div>
                        </div>

                        <table class="table table-hover table-bordered table-striped">
                            <tbody>
                            @for($d=1;$d<=7;$d++)
                                @php
                                    if($d==1)$day='saturday';
                                    else if($d==2)$day='sunday';
                                    else if($d==3)$day='monday';
                                    else if($d==4)$day='tuesday';
                                    else if($d==5)$day='wednesday';
                                    else if($d==6)$day='thursday';
                                    else if($d==7)$day='friday';
                                @endphp
                                <tr>
                                    <td class="day" style="vertical-align : middle;">{{$day}}</td>
                                    <td align="left">
                                        @foreach($routines as $row)
                                            @if($row->day ===$day)
                                                <div class="btn-group text-left">
                                                    <button type="button" class="btn btn-success dropdown-toggle"
                                                            data-toggle="dropdown"
                                                            aria-expanded="false">
                                                        <p style="margin-bottom: 0px;"><i
                                                                class="mdi mdi-book-open-variant"></i> {{ $row->subject_name }}
                                                        </p>
                                                        <p style="margin-bottom: 0px;"><i
                                                                class="mdi mdi-clock"></i>
                                                            {{ ( $row->time_start <= 12) ? $row->time_start. '.' .$row->time_start_min. ' AM' : ($row->time_start-12). '.' .$row->time_start_min. ' PM' }}
                                                            -
                                                            {{ ( $row->time_end <= 12) ? $row->time_end. '.' .$row->time_end_min. ' AM' : ($row->time_end-12). '.' .$row->time_end_min. ' PM' }}
                                                        </p>
                                                        <p style="margin-bottom: 0px;"><i
                                                                class="mdi mdi-account"></i> {{ $row->teacher_name }}
                                                        </p>
                                                        <p style="margin-bottom: 0px;"><i
                                                                class="mdi mdi-home-automation"></i> {{ $row->class_room }}
                                                        </p>
                                                    </button>
                                                </div>
                                            @endif
                                        @endforeach
                                    </td>
                                </tr>
                            @endfor
                            </tbody>
                        </table>
                    </div>
                    <hr/>
                    <div class="col-md-12">
                        <button type='button' id='btn' class='btn btn-success pull-right' value='Print'
                                onClick='printContent();'>Print Class Routine
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <style>
        .day {
            width: 100px;
            text-transform: capitalize;
            font-weight: bold;
            color: #747172;
            text-align: center;
        }
    </style>
    <script>
        document.body.classList.add("sidebar-collapse");
        function printContent() {
            $('#class_routine').printThis();
        }
    </script>

@endsection
