<?php

use App\Http\Controllers\Backend\Billal\FaqController;
use App\Http\Controllers\Backend\Billal\WhyChooseController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->controller(FaqController::class)->group(function () {

    Route::get('/faq', 'index')->name('faq.index');
    Route::post('/faq/store', 'store')->name('faq.store');
    Route::get('/faq/edit/{id}', 'edit')->name('faq.edit');
    Route::post('/faq/update/{id}', 'update')->name('faq.update');
    Route::delete('/faq/destroy/{id}', 'destroy')->name('faq.destroy');
    Route::post('/faq/toggle-status/{id}', 'toggleStatus')->name('faq.toggleStatus');

});



Route::middleware('auth')->controller(WhyChooseController::class)->group(function () {
    Route::get('/why-choose', 'index')->name('whychoose.index');
    Route::post('/why-choose/store', 'store')->name('whychoose.store');
     Route::get('/why-choose/data', 'getData')->name('whychoose.data');
    Route::get('/why-choose/edit/{id}', 'edit')->name('whychoose.edit'); // added GET edit
    Route::post('/why-choose/update/{id}', 'update')->name('whychoose.update');
    Route::delete('/why-choose/destroy/{id}', 'destroy')->name('whychoose.destroy'); // use DELETE
    Route::post('/why-choose/toggle-status/{id}', 'toggleStatus')->name('whychoose.toggleStatus');
});

