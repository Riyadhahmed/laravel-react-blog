<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\News;
use App\Http\Controllers\Controller;
use DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use View;
use Yajra\DataTables\DataTables;

class NewsController extends Controller
{
   /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function index()
   {
      return view('backend.admin.news.all');
   }

   public function allNews(Request $request)
   {
      if ($request->ajax()) {
         DB::statement(DB::raw('set @rownum=0'));
         $news = News::orderby('created_at', 'desc')->get(['news.*', DB::raw('@rownum  := @rownum  + 1 AS rownum')]);
         return Datatables::of($news)
           ->addColumn('action', 'backend.admin.news.action')
           ->addColumn('file_path', function ($news) {
              return "<img src='" . asset($news->file_path) . "' width='80px'>";
           })
           ->addColumn('status', function ($news) {
              return $news->status ? '<span class="label label-success">Active</span>' : '<span class="label label-danger">Inactive</span>';
           })
           ->rawColumns(['action', 'file_path', 'status'])
           ->make(true);
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Show the form for creating a new resource.
    *
    * @return \Illuminate\Http\Response
    */
   public function create(Request $request)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('notice-create');
         if ($haspermision) {
            $view = View::make('backend.admin.news.create')->render();
            return response()->json(['html' => $view]);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Store a newly created resource in storage.
    *
    * @param  \Illuminate\Http\Request $request
    * @return \Illuminate\Http\Response
    */
   public function store(Request $request)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('news-create');
         if ($haspermision) {

            $rules = [
              'title' => 'required',
              'photo' => 'max:2048|dimensions:max_width=2000,max_height=1000', // 2mb
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
               return response()->json([
                 'type' => 'error',
                 'errors' => $validator->getMessageBag()->toArray()
               ]);
            } else {

               $upload_ok = 1;
               $file_path = 'assets/images/blog/default_news_a.jpg';

               if ($request->hasFile('photo')) {
                  $extension = Input::file('photo')->getClientOriginalExtension();;
                  if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                     if (Input::file('photo')->isValid()) {
                        $destinationPath = 'assets/images/blog'; // upload path
                        $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
                        $fileName = time() . '.' . $extension; // renameing image
                        $file_path = 'assets/images/blog/' . $fileName;
                        Input::file('photo')->move($destinationPath, $fileName); // uploading file to given path
                        $upload_ok = 1;

                     } else {
                        return response()->json([
                          'type' => 'error',
                          'message' => "<div class='alert alert-warning'>File is not valid</div>"
                        ]);
                     }
                  } else {
                     return response()->json([
                       'type' => 'error',
                       'message' => "<div class='alert alert-warning'>Error! File type is not valid</div>"
                     ]);
                  }
               }

               if ($upload_ok == 0) {
                  return response()->json([
                    'type' => 'error',
                    'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
                  ]);
               } else {
                  $blog = new News;
                  $blog->title = $request->input('title');
                  $blog->description = $request->input('description');
                  $blog->category = $request->input('category');
                  $blog->uploaded_by = auth()->user()->id;
                  $blog->file_path = $file_path;
                  $blog->save(); //
                  return response()->json(['type' => 'success', 'message' => "Successfully Created"]);
               }
            }
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

   /**
    * Display the specified resource.
    *
    * @param  \App\Models\News $news
    * @return \Illuminate\Http\Response
    */
   public function show(Request $request, News $news)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('notice-view');
         if ($haspermision) {
            $view = View::make('backend.admin.news.view', compact('news'))->render();
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
    * @param  \App\Models\News $news
    * @return \Illuminate\Http\Response
    */
   public function edit(Request $request, News $news)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('notice-edit');
         if ($haspermision) {
            $view = View::make('backend.admin.news.edit', compact('news'))->render();
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
    * @param  \App\Models\News $news
    * @return \Illuminate\Http\Response
    */
   public function update(Request $request, News $news)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('news-edit');
         if ($haspermision) {

            $rules = [
              'title' => 'required',
              'photo' => 'max:2048|dimensions:max_width=2000,max_height=1000', // 2mb
            ];

            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
               return response()->json([
                 'type' => 'error',
                 'errors' => $validator->getMessageBag()->toArray()
               ]);
            } else {

               if ($request->hasFile('photo')) {
                  $extension = Input::file('photo')->getClientOriginalExtension();;
                  if ($extension == "jpg" || $extension == "jpeg" || $extension == "png") {
                     if (Input::file('photo')->isValid()) {
                        $destinationPath = 'assets/images/blog'; // upload path
                        $extension = Input::file('photo')->getClientOriginalExtension(); // getting image extension
                        $fileName = time() . '.' . $extension; // renameing image
                        $file_path = 'assets/images/blog/' . $fileName;
                        Input::file('photo')->move($destinationPath, $fileName); // uploading file to given path
                        $upload_ok = 1;

                     } else {
                        return response()->json([
                          'type' => 'error',
                          'message' => "<div class='alert alert-warning'>File is not valid</div>"
                        ]);
                     }
                  } else {
                     return response()->json([
                       'type' => 'error',
                       'message' => "<div class='alert alert-warning'>Error! File type is not valid</div>"
                     ]);
                  }
               } else {
                  $upload_ok = 1;
                  $file_path = $request->input('SelectedFileName');
               }

               if ($upload_ok == 0) {
                  return response()->json([
                    'type' => 'error',
                    'message' => "<div class='alert alert-warning'>Sorry Failed</div>"
                  ]);
               } else {
                  $blog = News::findOrFail($news->id);
                  $blog->title = $request->input('title');
                  $blog->description = $request->input('description');
                  $blog->category = $request->input('category');
                  $blog->uploaded_by = auth()->user()->id;
                  $blog->file_path = $file_path;
                  $blog->status = $request->input('status');
                  $blog->save(); //
                  return response()->json(['type' => 'success', 'message' => "Successfully Updated"]);
               }
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
    * @param  \App\Models\News $news
    * @return \Illuminate\Http\Response
    */
   public function destroy(Request $request, News $news)
   {
      if ($request->ajax()) {
         $haspermision = auth()->user()->can('notice-delete');
         if ($haspermision) {
            $news->delete();
            return response()->json(['type' => 'success', 'message' => 'Successfully Deleted']);
         } else {
            abort(403, 'Sorry, you are not authorized to access the page');
         }
      } else {
         return response()->json(['status' => 'false', 'message' => "Access only ajax request"]);
      }
   }

}
