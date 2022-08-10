<?php

use Illuminate\Support\Facades\Route;

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
    return view('welcome');
});


/**
 * Create user and token for API Authorization
 */
Route::get('/setup', function() {
    $credentials = [
        'email' => 'hkk@abc.com',
        'password' => 'password',
    ];

    if(!Auth::attempt($credentials)) {
        $user = new App\Models\User();
        $user->name = 'Admin';
        $user->email = $credentials['email'];
        $user->password = Hash::make($credentials['password']);
        $user->save();

        if(Auth::attempt($credentials)) {
            $user = Auth::user();

            $basicToken = $user->createToken('admin-token');

            return [
                'admin' => $basicToken->plainTextToken
            ];
        }
    }
});
