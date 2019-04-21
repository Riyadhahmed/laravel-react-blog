<?php

// Bakcend

Auth::routes();

// Admin Dashborad
Route::group([
  'namespace' => 'Backend\Admin',
  'prefix' => 'admin',
  'as' => 'admin.',
  'middleware' => 'auth'],
  function () {
     require base_path('routes/backend/admin.php');
  });


Route::view('/{path?}', 'frontend.index')->where('path', '.*');