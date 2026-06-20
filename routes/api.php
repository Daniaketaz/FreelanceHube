<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



require __DIR__.'/auth.php';
require __DIR__.'/clients.php';
//require __DIR__.'/settings.php';
//require __DIR__.'/clients.php';
///todo section

/// Route::('password reset ')
/// Route::('update profile')
/// Route::('delete')
/// Route::('create client')
/// Route::('update client')
/// Route::('delete client')
/// Route::('view all client')
/// Route::('view client details')
/// Route::('create project')
/// Route::('update project')
/// Route::('delete project')
/// Route::('assign project to client ')
/// Route::('change project status ')
/// Route::('view all projects')
/// Route::('view project details ')
/// Route::('View projects by status')
/// Route::('View projects by client')
/// Route::('')
/// Route::('')
/// Route::('')
/// Route::('')
/// Route::('')
/// Route::('')
/// Route::('')
/// Route::('')
/// Route::('')
/// Route::('')
/// Route::('')
/// Route::('')
/// Route::('')
/// Route::('')
/// Route::('')
