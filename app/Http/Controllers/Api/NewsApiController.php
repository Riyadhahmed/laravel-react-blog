<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use DB;

class NewsApiController extends Controller
{
   public function allBlogs(Request $request)
   {
      $limit = $request->input('limit');
      $offset = $request->input('offset');
      $total = News::count();
      $pagData = DB::table('news')->offset($offset)->limit($limit)->get();
      return response()->json(['result' => $pagData, 'total' => $total]);
   }

   public function show($id)
   {
      $news = News::find($id);
      return response()->json(['result' => $news]);
   }

   public function blogWidget(Request $request)
   {
      $category = $request->input('category');
      $limit = $request->input('limit');
      $pagData = DB::table('news')->where('category', $category)->limit($limit)->get();
      return response()->json(['result' => $pagData]);
   }
}