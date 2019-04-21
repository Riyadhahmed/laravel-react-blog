<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\News;
use View;


class HomeController extends Controller
{

   public function index()
   {
      return view('frontend.index');
   }

   public function news()
   {
      $latest_news = News::where('category', 'Latest News')->where('status', 1)->orderby('created_at', 'desc')->take(4)->get();
      return View::make('frontend.index', compact('latest_news'));
   }

   // News Details
   public function viewNews(News $news)
   {
      return view('frontend.newsDetails', compact('news'));
   }


}
