<?php

Route::get('/', 'StudentSelfController@index')->name('dashboard');
Route::get('/profile', 'StudentSelfController@profile')->name('profile');
Route::get('/edit_profile', 'StudentSelfController@edit')->name('edit_profile');
Route::patch('/edit_profile', 'StudentSelfController@update')->name('edit_profile');
Route::get('/change_password', 'StudentSelfController@change_password')->name('change_password');
Route::patch('/change_password', 'StudentSelfController@update_password')->name('change_password');

Route::get('/getClassroutines', 'StudentSelfController@getClassroutines')->name('getClassroutines');

Route::get('/getAcademicResult', 'StudentSelfController@getAcademicResult')->name('getAcademicResult');
Route::post('/generateMarksheet', 'StudentSelfController@generateMarksheet')->name('generateMarksheet');

Route::get('/attendance', 'StudentSelfController@getAttendance')->name('attendance');
Route::post('/attendance', 'StudentSelfController@attendanceReport')->name('attendance');

Route::get('/syllabus', 'StudentSelfController@syllabus')->name('syllabus');
Route::get('/getSyllabus', 'StudentSelfController@getSyllabus')->name('getSyllabus.syllabus');