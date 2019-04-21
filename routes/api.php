<?php


Route::get('/allBlogs', 'Api\NewsApiController@allBlogs');
Route::get('/blog/{id}', 'Api\NewsApiController@show');

Route::get('/blogWidget', 'Api\NewsApiController@blogWidget');