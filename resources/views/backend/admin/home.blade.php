@extends('backend.layouts.master')
@section('title', ' Dashboard')
@section('content')
    <!-- /.row -->
    <!-- Info boxes -->
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-aqua"><i class="mdi mdi-account-group"></i></span>
                    <div class="info-box-content">
                        <span class="info-box-text">Users </span>
                        <span class="info-box-number">{{$users}}</span>
                        <span><a href="" class="small-box-footer">View All <i
                                    class="fa fa-arrow-circle-right"></i></a></span>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-red"><i class="mdi mdi-account-group"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Members</span>
                        <span class="info-box-number"> </span>
                        <a href="" class="small-box-footer">View All <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->

            <!-- fix for small devices only -->
            <div class="clearfix visible-sm-block"></div>

            <div class="col-md-4 col-sm-6 col-xs-12">
                <div class="info-box">
                    <span class="info-box-icon bg-green"><i class="mdi mdi-blogger"></i></span>

                    <div class="info-box-content">
                        <span class="info-box-text">Blogs</span>
                        <span class="info-box-number">{{$blogs}}</span>
                        <a href="{{ URL :: to('/admin/news') }}" class="small-box-footer">View All <i
                                class="fa fa-arrow-circle-right"></i></a>
                    </div>
                    <!-- /.info-box-content -->
                </div>
                <!-- /.info-box -->
            </div>
            <!-- /.col -->
        </div>
        <!-- /.row -->
    </div>
    <!-- /.row -->
@endsection
