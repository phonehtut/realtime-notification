<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Events\SampleNotification;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/form', function () {
    return view('notification');
});

Route::post('/notification', function () {

    $data = request()->message;

    event(new SampleNotification($data));

   return view('welcome');
});

Route::post('/notify', function (Request $request) {
    $message = $request->input('message');
    broadcast(new SampleNotification($message)); // Ensure this line executes
    return response()->json(['status' => 'Notification sent!']);
});

Route::get('/test-notification', function () {
    broadcast(new SampleNotification('Test message'));
    return 'Notification sent!';
});

