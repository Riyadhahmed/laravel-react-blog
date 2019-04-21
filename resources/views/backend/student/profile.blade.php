@extends('backend.layouts.student_master')
@section('title', 'Profile')
@section('content')
    <div class="row">
        <div class="col-md-12">
            <!-- Custom Tabs -->
            <div class="nav-tabs-custom">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#student" data-toggle="tab" aria-expanded="true">Students Information</a>
                    </li>
                    <li class=""><a href="#parent" data-toggle="tab" aria-expanded="false">Parent Information</a></li>
                </ul>
                <div class="tab-content">
                    <div class="tab-pane active" id="student">
                        <div class="col-md-8 col-sm-12 table-responsive">
                            <table id="view_details" class="table table-bordered table-hover">
                                <tbody>
                                <tr>
                                    <td class="subject"> Students's Name</td>
                                    <td> :</td>
                                    <td> {{ $student->name }} </td>
                                </tr>
                                <tr>
                                    <td class="subject"> Class</td>
                                    <td> :</td>
                                    <td> {{ $enroll->stdclass->name }} </td>
                                </tr>
                                <tr>
                                    <td class="subject"> Section</td>
                                    <td> :</td>
                                    <td> {{ $enroll->section->name }} </td>
                                </tr>
                                <tr>
                                    <td class="subject"> Roll</td>
                                    <td> :</td>
                                    <td> {{ $enroll->roll }} </td>
                                </tr>
                                <tr>
                                    <td class="subject"> Optional Subject</td>
                                    <td> :</td>
                                    <td> {{ $enroll->subject ? $enroll->subject->name : 'Not Selected' }} </td>
                                </tr>
                                <tr>
                                    <td class="subject"> Gender</td>
                                    <td> :</td>
                                    <td> {{ $student->gender }} </td>
                                </tr>
                                <tr>
                                    <td class="subject"> Date of Birth</td>
                                    <td> :</td>
                                    <td> {{ $student->dob }} </td>
                                </tr>
                                <tr>
                                    <td class="subject"> Phone</td>
                                    <td> :</td>
                                    <td> {{ $student->phone }} </td>
                                </tr>
                                <tr>
                                    <td class="subject"> Email</td>
                                    <td> :</td>
                                    <td> {{ $student->email }} </td>
                                </tr>
                                <tr>
                                    <td class="subject"> Address</td>
                                    <td> :</td>
                                    <td> {{ $student->address }}</td>
                                </tr>
                                <tr>
                                    <td class="subject"> Blood Group</td>
                                    <td> :</td>
                                    <td> {{ $student->blood_group }} </td>
                                </tr>
                                <tr>
                                    <td class="subject"> Parents's ID</td>
                                    <td> :</td>
                                    <td> {{ $student->parent_id }} </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="col-md-4 col-sm-12 short_inf">
                            <img src="{{ asset($student->file_path) }}" class="img-responsive img-thumbnail"
                                 width="200px"/><br/><br/>
                            Name : {{ $student->name  }} <br/>
                            Student's Code : {{ $student->std_code  }} <br/>
                            Class : {{ $enroll->stdclass->name }} , Section : {{ $enroll->section->name }} , Roll
                            : {{ $enroll->roll  }} <br/>
                            Email : {{ $student->email  }} <br/>
                            Phone : {{ $student->phone  }} <br/>
                        </div>
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="parent">
                        @if($parent)
                            <div class="col-md-8 col-sm-12 table-responsive">
                                <table id="view_details" class="table table-bordered table-hover">
                                    <tbody>
                                    <tr>
                                        <td class="subject"> Parents's Name</td>
                                        <td> :</td>
                                        <td> {{ $parent->name }} </td>
                                    </tr>
                                    <tr>
                                        <td class="subject"> Parents's ID</td>
                                        <td> :</td>
                                        <td> {{ $parent->parent_code }} </td>
                                    </tr>
                                    <tr>
                                        <td class="subject"> Gender</td>
                                        <td> :</td>
                                        <td> {{ $parent->gender }} </td>
                                    </tr>
                                    <tr>
                                        <td class="subject"> Phone</td>
                                        <td> :</td>
                                        <td> {{ $parent->phone }} </td>
                                    </tr>
                                    <tr>
                                        <td class="subject"> Email</td>
                                        <td> :</td>
                                        <td> {{ $parent->email }} </td>
                                    </tr>
                                    <tr>
                                        <td class="subject"> Profession</td>
                                        <td> :</td>
                                        <td> {{ $parent->profession }}</td>
                                    </tr>
                                    <tr>
                                        <td class="subject"> Blood Group</td>
                                        <td> :</td>
                                        <td> {{ $parent->blood_group }} </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-md-4 col-sm-12">
                                <img src="{{ asset($parent->file_path) }}" class="img-responsive img-thumbnail"
                                     width="200px"/><br/><br/>
                                Name : {{ $parent->name  }} <br/>
                                Email : {{ $parent->email  }} <br/>
                                Phone : {{ $parent->phone  }} <br/>
                            </div>
                        @endif
                    </div>
                    <!-- /.tab-pane -->
                    <div class="clearfix"></div>
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- nav-tabs-custom -->
        </div>
    </div>
@endsection
