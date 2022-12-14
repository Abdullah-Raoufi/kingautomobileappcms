<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

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

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return Inertia::render('Dashboard');
    })->name('dashboard');
    Route::get('/cars', function () {
        
        return Inertia::render('MainProject/Cars');
    })->name('cars');

    Route::get('/addNewCar', function () {
        
        return Inertia::render('MainProject/AddNewCar');
    })->name('addNewCar');

    Route::get('/editCar/{doc_id?}', function ($doc_id) {

     
        return Inertia::render('MainProject/EditCar',[

            'doc_id' => $doc_id
            ]
            
    );
    })->name('editCar');

    Route::get('/bits', function () {
        
        return Inertia::render('MainProject/Bits');
    })->name('bits');


    Route::get('/car-details/{doc_id?}', function ($doc_id) {

     
        return Inertia::render('MainProject/CarDetails',[

            'doc_id' => $doc_id
            ]
            
    );
    })->name('CarDetails');

    
    Route::get('/bit-details/{doc_id?}', function ($doc_id) {

      
        return Inertia::render('MainProject/BitDetails',[
            'doc_id' => $doc_id
            ]
            
    );
    })->name('BitDetails');




});
