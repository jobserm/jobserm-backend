 <?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::apiResource('jobs',\App\Http\Controllers\Api\JobController::class);
Route::apiResource('reviews', \App\Http\Controllers\Api\ReviewController::class)
    ->middleware('auth:api');

Route::apiResource('jobs',\App\Http\Controllers\Api\JobController::class);

Route::apiResource('reviews', \App\Http\Controllers\Api\ReviewController::class);

Route::apiResource('categories', \App\Http\Controllers\Api\CategoryController::class);

Route::apiResource('users', \App\Http\Controllers\Api\UserController::class);

Route::apiResource('images', \App\Http\Controllers\Api\ImageController::class);

Route::post('/users/{user}/first-register', [\App\Http\Controllers\Api\UserController::class, 'firstRegister'])
    ->middleware('api')->name('users.firstRegister');

Route::post('/jobs/{job}/apply-job', [\App\Http\Controllers\Api\JobController::class, 'userApplyJob'])
    ->middleware('api')->name('jobs.userApplyJob');

Route::put('/jobs/{job}/select-freelancer', [\App\Http\Controllers\Api\JobController::class, 'employerSelectFreelancer'])
    ->middleware('api')->name('jobs.employerSelectFreelancer');

Route::get('/jobs/{job}/report-inappropriate', [\App\Http\Controllers\Api\JobController::class, 'reportInappropriateJob'])
    ->middleware('api')->name('jobs.reportInappropriateJob');

Route::get('/jobs/{job}/finish-job', [\App\Http\Controllers\Api\JobController::class, 'finishJob'])
     ->middleware('api')->name('jobs.finishJob');

Route::get('/get-all-jobs', [\App\Http\Controllers\Api\JobController::class, 'getAllJobs'])
     ->middleware('api')->name('jobs.getAllJobs');

 Route::post('/jobs/{job}/get-rand-jobs', [\App\Http\Controllers\Api\JobController::class, 'getRandJobs'])
     ->middleware('api')->name('jobs.getRandJobs');

 Route::post('/get-job-by-user-id', [\App\Http\Controllers\Api\JobController::class, 'getJobByUser'])
     ->middleware('api')->name('jobs.getJobByUser');


Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('login', [\App\Http\Controllers\Api\AuthController::class, 'login']);
    Route::post('register', [\App\Http\Controllers\Api\AuthController::class, 'register']);
    Route::post('logout', [\App\Http\Controllers\Api\AuthController::class, 'logout']);
    Route::post('refresh', [\App\Http\Controllers\Api\AuthController::class, 'refresh']);
    Route::post('me', [\App\Http\Controllers\Api\AuthController::class, 'me']);

});
