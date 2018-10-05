<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/', 'CustomersController@index')->name('home');
Route::get('/customers', 'CustomersController@getCustomersBySearchString')->name('customers');
Route::post('/visitors', 'VisitorsController@addVisitors');

Route::get('test', function (\App\Listeners\Visitor\VisitorListener $listener) {
    //$event = new \App\Events\VisitorCreated(1, '1221');
    event(new \App\Events\VisitorCreated(11, '62.221.40.178'));
});