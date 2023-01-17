<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Controller;

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

Route::get('/', [Controller::class, 'welcome']);

require __DIR__.'/auth.php';
require __DIR__.'/core.php';
require __DIR__.'/college.php';
require __DIR__.'/blog.php';
require __DIR__.'/loyalty.php';
require __DIR__.'/template.php';
require __DIR__.'/mailer.php';
require __DIR__.'/page.php';



