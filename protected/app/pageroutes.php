<?php 
Route::get('pages/trang-chu-{id}.html', 'HomeController@page')->where(array('id'=>'[0-9]+'));
Route::get('contact-us', 'HomeController@page')->where(array('id'=>'[0-9]+'));
Route::get('pages/gioi-thieu-{id}.html', 'HomeController@page')->where(array('id'=>'[0-9]+'));
Route::get('pages/huong-dan-dang-tin-{id}.html', 'HomeController@page')->where(array('id'=>'[0-9]+'));
Route::get('pages/about-us-{id}.html', 'HomeController@page')->where(array('id'=>'[0-9]+'));
?>