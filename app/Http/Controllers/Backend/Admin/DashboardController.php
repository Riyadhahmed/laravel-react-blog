<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Http\Controllers\Controller;
use App\Models\Enroll;
use App\Models\News;
use App\Models\StdParent;
use App\Models\Teacher;
use App\Models\User;
use View;

class DashboardController extends Controller
{

   /**
    * Show the application dashboard.
    *
    * @return \Illuminate\Contracts\Support\Renderable
    */
   public function index()
   {
      $users = User::all()->count();
      $blogs = News::all()->count();
      return View::make('backend.admin.home', compact('users', 'blogs'));
   }


}
