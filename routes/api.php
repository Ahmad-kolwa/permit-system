<?php
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ParkController;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\PermitController;
//use App\Http\Controllers\Api\ReportController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


 

Route::prefix('v1')->group(function () {

    Route::post('/login', [AuthController::class,'login']);
     Route::post('/users', [UserController::class,'store']); 
    

    Route::middleware('auth:sanctum')->group(function () {

    //PARKS
  Route::post('/parks',[ParkController::class,'store']);
        Route::get('/parks', [ParkController::class,'index']);
          Route::put('/parks/{id}', [ParkController::class,'update']);
 Route::delete('/parks/{id}', [ParkController::class,'destroy']);
Route::post('/permits', [PermitController::class,'store']);
        Route::get('/permits', [PermitController::class,'index']);
Route::get('/permits/cancelled', [PermitController::class,'cancelled']);
        Route::get('/permits/{code}', [PermitController::class,'show']);

              Route::put(
            '/permits/{code}/cancel',
            [PermitController::class, 'cancel']
        );

              Route::post(
            '/permits/{code}/pay',
            [PermitController::class, 'pay']
        );

    
  //  Route::post('/parks',[ParkController::class,'store']);

  
    
    Route::delete('/permits/{id}',
        [PermitController::class,'destroy']);
        Route::post('reports/revenue', [ReportController::class, 'revenue'])
    ->middleware('role:admin');
            });

});






// Route::middleware([
//     'auth:sanctum',
//     'role:admin'
// ])->get(
//     '/reports/revenue',
//     [ReportController::class,'revenue']
// );

