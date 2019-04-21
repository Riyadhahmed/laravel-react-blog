<?php

  Route::view('/{path?}', 'frontend.index')->where('path', '.*');

//Route::get('{all?}', 'HomeController@index')->where('all', '([A-z\d-\/_.]+)?');
