<?php

namespace App\Http\Controllers\Backend\Student;

use App\Helper\GenerateMarksheet;
use App\Models\Enroll;
use App\Models\Exam;
use App\Models\StdParent;
use App\Models\Syllabus;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use View;
use DB;

class StudentSelfController extends Controller
{

   public function index()
   {
      return view('backend.student.home');
   }

   public function profile()
   {
      $student = Auth::user();
      $parent = StdParent::where('parent_code', $student->std_code)->first();
      $enroll = Enroll::where('student_id', $student->id)
        ->where('year', config('running_session'))
        ->first();
      return view('backend.student.profile', compact('parent', 'student', 'enroll'));
   }

   public function edit()
   {
      $student = Auth::user();
      return view('backend.student.edit_profile', compact('student'));
   }

   public function update(Request $request)
   {
      if ($request->ajax()) {

         $student = Auth::user();

         $rules = [
           'name' => 'required',
            // 'std_code' => 'required|unique:students,std_code,' . $student->id,
           'phone' => 'required|unique:students,phone,' . $student->id,
           'photo' => 'image|max:2024|mimes:jpeg,jpg,gif,png'
         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
            return response()->json([
              'type' => 'error',
              'errors' => $validator->getMessageBag()->toArray()
            ]);
         } else {

            $upload_ok = 1;
            $file_path = $request->input('SelectedFileName');

            if ($request->hasFile('photo')) {

               if (Input::file('photo')->isValid()) {
                  File::delete($student->file_path);
                  $destinationPath = 'assets/images/student_image'; // upload path
                  $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
                  $fileName = time() . '.' . $extension; // renameing image
                  $file_path = 'assets/images/student_image/' . $fileName;
                  Input::file('photo')->move($destinationPath, $fileName); // uploading file to given path
                  $upload_ok = 1;

               } else {
                  return response()->json([
                    'type' => 'error',
                    'message' => "<div class='alert alert-warning'>Please! File is not valid</div>"
                  ]);
               }
            }
            if ($upload_ok == 0) {
               return response()->json([
                 'type' => 'error',
                 'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
               ]);
            } else {

               $student->name = $request->input('name');
               // $student->std_code = $request->input('std_code');
               $student->dob = $request->input('dob');
               $student->gender = $request->input('gender');
               $student->religion = $request->input('religion');
               $student->blood_group = $request->input('blood_group');
               $student->address = $request->input('address');
               $student->phone = $request->input('phone');
               $student->email = $request->input('email');
               $student->file_path = $file_path;
               $student->save(); //
               return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);

            }
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function change_password()
   {
      return view('backend.student.change_password');
   }

   public function update_password(Request $request)
   {
      if ($request->ajax()) {

         $student = Auth::user();

         $rules = [
           'password' => 'required'
         ];

         $validator = Validator::make($request->all(), $rules);
         if ($validator->fails()) {
            return response()->json([
              'type' => 'error',
              'errors' => $validator->getMessageBag()->toArray()
            ]);
         } else {
            $student->password = Hash::make($request->input('password'));
            $student->save(); //
            return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function getClassroutines()
   {
      $student_id = Auth::user()->id;
      $year = config('running_session');
      $students = DB::table('enrolls')
        ->join('students', 'students.id', '=', 'enrolls.student_id')
        ->join('sections', 'sections.id', '=', 'enrolls.section_id')
        ->join('std_classes', 'std_classes.id', '=', 'enrolls.class_id')
        ->select('enrolls.*', 'students.std_code', 'students.name as student_name',
          'std_classes.name as class_name', 'sections.name as section_name')
        ->where('enrolls.student_id', $student_id)
        ->where('enrolls.year', $year)->get();


      foreach ($students as $student) {
         $class_id = $student->class_id;
         $section_id = $student->section_id;
         $class_name = $student->class_name;
         $section_name = $student->section_name;
      }


      $data = array();
      $data['class_id'] = $class_id;
      $data['section_id'] = $section_id;
      $data['class_name'] = $class_name;
      $data['section_name'] = $section_name;
      $data['year'] = $year;

      $routines = DB::table('class_routines')
        ->join('subjects', 'subjects.id', '=', 'class_routines.subject_id')
        ->join('sections', 'sections.id', '=', 'class_routines.section_id')
        ->join('class_rooms', 'class_rooms.id', '=', 'class_routines.class_room_id')
        ->join('teachers', 'teachers.id', '=', 'class_routines.teacher_id')
        ->select('class_routines.*', 'subjects.name as subject_name', 'sections.name as section_name',
          'teachers.name as teacher_name', 'class_rooms.name as class_room')
        ->where('class_routines.class_id', $class_id)
        ->where('class_routines.section_id', $section_id)
        ->where('class_routines.year', $year)
        ->orderby('class_routines.time_start', 'asc')->get();

      return view('backend.student.class_routine', compact('routines', 'data'));
   }

   public function syllabus()
   {
      return view('backend.student.syllabus');
   }

   public function getSyllabus()
   {
      $student_id = Auth::user()->id;
      $year = config('running_session');

      $student = Enroll:: where('student_id', $student_id)->where('year', $year)->first();
      $class_id = $student->class_id;
      $section_id = $student->section_id;

      DB::statement(DB::raw('set @rownum=0'));
      $syllabus = Syllabus::where('class_id', $class_id)->where('section_id', $section_id)->where('year', config('running_session'))->orderby('created_at', 'desc')->get(['syllabus.*', DB::raw('@rownum  := @rownum  + 1 AS rownum')]);
      return Datatables::of($syllabus)
        ->addColumn('class', function ($syllabus) {
           return $syllabus->stdclass ? $syllabus->stdclass->name : '';
        })
        ->addColumn('subject', function ($syllabus) {
           return $syllabus->subject ? $syllabus->subject->name : '';
        })
        ->addColumn('file_path', function ($syllabus) {
           return $syllabus->file_path ? "<a class='btn btn-primary' href='" . asset($syllabus->file_path) . "'>Download</a>" : '';
        })
        ->rawColumns(['action', 'file_path'])
        ->make(true);
   }

   public function getAttendance()
   {
      return view('backend.student.attendance');
   }

   public function attendanceReport(Request $request)
   {
      if ($request->ajax()) {

         $student_id = Auth::user()->id;
         $year = config('running_session');
         $students = DB::table('enrolls')
           ->join('students', 'students.id', '=', 'enrolls.student_id')
           ->join('sections', 'sections.id', '=', 'enrolls.section_id')
           ->join('std_classes', 'std_classes.id', '=', 'enrolls.class_id')
           ->select('enrolls.*', 'students.std_code', 'students.name as student_name',
             'std_classes.name as class_name', 'sections.name as section_name')
           ->where('enrolls.student_id', $student_id)
           ->where('enrolls.year', $year)->get();


         foreach ($students as $student) {
            $class_id = $student->class_id;
            $section_id = $student->section_id;
            $class_name = $student->class_name;
            $section_name = $student->section_name;
            $std_code = $student->std_code;
         }


         $data = array();
         $data['class_id'] = $class_id;
         $data['section_id'] = $section_id;
         $data['class_name'] = $class_name;
         $data['section_name'] = $section_name;
         $data['std_code'] = $std_code;
         $data['month'] = $request->input('month');
         $data['year'] = $year;

         DB::statement(DB::raw("set @rownum=0, @year='$year'"));
         $data['result'] = DB::table('enrolls')
           ->join('students', 'students.id', '=', 'enrolls.student_id')
           ->select('students.name as std_name', 'students.id as std_id',
             'students.std_code', DB::raw('@rownum  := @rownum  + 1 AS rownum'))
           ->where('enrolls.class_id', $class_id)
           ->where('enrolls.student_id', $student_id)
           ->where('enrolls.section_id', $section_id)
           ->where('enrolls.year', $year)
           ->orderBy('students.std_code', 'asc')
           ->get();
         $view = View::make('backend.student.attendance_report', compact('data'))->render();
         return response()->json(['html' => $view]);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   public function getAcademicResult()
   {
      $year = config('running_session');
      $exams = Exam::where('year', $year)->orderBy('created_at', 'desc')->get();
      return view('backend.student.result', compact('exams'));
   }

   public function generateMarksheet(Request $request)
   {

      $student_id = Auth::user()->id;
      $year = config('running_session');
      $students = DB::table('enrolls')
        ->join('students', 'students.id', '=', 'enrolls.student_id')
        ->join('sections', 'sections.id', '=', 'enrolls.section_id')
        ->join('std_classes', 'std_classes.id', '=', 'enrolls.class_id')
        ->select('enrolls.*', 'students.std_code', 'students.name as student_name',
          'std_classes.name as class_name', 'sections.name as section_name')
        ->where('enrolls.student_id', $student_id)
        ->where('enrolls.year', $year)->get();


      foreach ($students as $student) {
         $class_id = $student->class_id;
         $section_id = $student->section_id;
         $student_code = $student->std_code;
         $student_name = $student->student_name;
         $roll = $student->roll;
         $class_name = $student->class_name;
         $section_name = $student->section_name;
      }


      $exam_id = $request->input('exam_id');


      $exam = Exam::where('id', $exam_id)->first();

      $data = array();
      $data['student_code'] = $student_code;
      $data['student_name'] = $student_name;
      $data['std_roll'] = $roll;
      $data['class_id'] = $class_id;
      $data['section_id'] = $section_id;
      $data['exam_id'] = $exam_id;
      $data['class_name'] = $class_name;
      $data['section_name'] = $section_name;
      $data['exam_name'] = $exam->name;
      $data['year'] = $year;
      $data['has_ct'] = $exam->ct_marks_percentage;
      $data['mmp'] = $exam->main_marks_percentage;
      $data['result'] = GenerateMarksheet::generateMarksheet($exam_id, $class_id, $section_id, $student_code, $year);
      $view = View::make('backend.admin.tabulation_sheet.marksheet', compact('data'))->render();
      return response()->json(['html' => $view]);

   }
}
