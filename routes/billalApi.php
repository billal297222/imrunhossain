<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Billal\ContractUsController;
use App\Http\Controllers\Api\ReviewController;



Route::controller(ContractUsController::class)->group(function () {

    Route::post('/contact-us', 'submitContactUsForm');
});
