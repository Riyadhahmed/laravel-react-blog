<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\File;
use DB;
use View;


class SettingsController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      return view('backend.admin.setting.all');
   }

   public function allSetting()
   {
      DB::statement(DB::raw('set @rownum=0'));
      $settings = Setting::get(['settings.*', DB::raw('@rownum  := @rownum  + 1 AS rownum')]);
      return DataTables::of($settings)
        ->addColumn('action', 'backend.admin.setting.action')
        ->addColumn('layout', function ($settings) {
           return $settings->layout ? '<span class="label label-success">Fullwidth</span>' : '<span class="label label-danger">Boxed</span>';
        })
        ->rawColumns(['layout', 'action'])
        ->make(true);
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create(Request $request)
   {
      //
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      //
   }

   /**
    * Display the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request, $id)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('settings-view');
         if ($haspermision) {
            $settings = Setting::findOrFail($id);
            $view = View::make('backend.admin.setting.view', compact('settings'))->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Show the form for editing the specified resource.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function edit(Request $request, Setting $setting)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('settings-create');
         if ($haspermision) {
            $settings = Setting::findOrFail($setting->id);
            $view = View::make('backend.admin.setting.edit', compact('settings'))->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Update the specified resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, Setting $setting)
   {
      //
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('settings-create');
         if ($haspermision) {

            $settings = Setting::findOrFail($setting->id);
            $old_file = $settings->logo;
            $rules = [
              'name' => 'required',
              'email' => 'required|email|unique:settings,email,' . $setting->id,
              'contact' => 'required',
              'address' => 'required'
            ];
            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
               return response()->json(['type' => 'error', 'errors' => $validator->getMessageBag()->toArray()]);
            } else {

               if ($request->hasFile('logo')) {
                  // return 'has file';
                  $rules = [
                    'logo' => 'required|image|max:1024|mimes:jpeg,jpg,gif,bmp,png'
                  ];
                  $messages = [
                    'logo.required' => 'Please choose an image'
                  ];

                  $validator = Validator::make($request->all(), $rules, $messages);

                  if ($validator->fails()) {
                     return response()->json([
                       'type' => 'error',
                       'message' => "<div class='alert alert-warning'>Please! Choose an Image File  with jpg , jpeg , png format</div>"
                     ]);
                  } else {

                     if (Input::file('logo')->isValid()) {
                        $destinationPath = 'assets/images/logo'; // upload path
                        $extension = Input::file('logo')->getClientOriginalExtension(); // getting image extension
                        $fileName = time() . '.' . $extension; // renameing image
                        $file_path = 'assets/images/logo/' . $fileName;
                        $result = Input::file('logo')->move($destinationPath, $fileName); // uploading file to given path
                        $upload_ok = 1;
                        File::delete($old_file); //unlink($old_file);
                        // dd($delete);
                     } else {
                        $upload_ok = 0;
                        return response()->json([
                          'type' => 'error',
                          'message' => "<div class='alert alert-warning'>Please! File is not valid</div>"
                        ]);
                     }

                  }
               } else {
                  $file_path = $old_file;
                  $upload_ok = 1;
               }
            }

            if ($upload_ok == 0) {
               return response()->json([
                 'type' => 'error',
                 'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
               ]);
            } else {
               $settings->name = $request->input('name');
               $settings->slogan = $request->input('slogan');
               $settings->contact = $request->input('contact');
               $settings->stablished = $request->input('stablished');
               $settings->website = $request->input('website');
               $settings->reg = $request->input('reg');
               $settings->email = $request->input('email');
               $settings->address = $request->input('address');
               $settings->running_year = trim($request->input('running_year'));
               $settings->logo = $file_path;
               $settings->layout = $request->input('layout');
               $settings->created_at = Carbon::now();
               $settings->updated_at = Carbon::now();
               $settings->save();
               return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
            }


         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }

   }

   /**
    * Remove the specified resource from storage.
    *
    * @param  int $id
    * @return \Illuminate\Http\Response
    */
   public function destroy(Request $request, Setting $setting)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('settings-delete');
         if ($haspermision) {
            $setting->delete();
            return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }
}
