<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\UserInfoController;

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

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

// Route::get('welcome','App\Http\Controllers\Master@Welcome');

//API route for register new user & login user.............
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

//API route for forgot & reset password....................
Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
Route::post('/reset-password', [AuthController::class, 'resetpass']);

//Protecting Routes........................................
Route::group(['middleware' => ['auth:sanctum']], function () {

    // API route for logout user..........................
    Route::post('/logout', [AuthController::class, 'logout']);


    //API route for user info...................................
    Route::get('/usersinfo', [UserInfoController::class, 'index']);
    Route::get('/userinfo', [UserInfoController::class, 'show_user']);
    Route::post('/userinfo/create', [UserInfoController::class, 'create']);
    Route::post('/userinfo/update/{id}', [UserInfoController::class, 'update']);
    Route::delete('/userinfo/delete/{id}', [UserInfoController::class, 'delete']);

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    |
    */

    Route::get('dashboard','App\Http\Controllers\API\Admin@dashboard');

    /*
    |--------------------------------------------------------------------------
    | Menu Management 
    |--------------------------------------------------------------------------
    |
    */

    Route::get('menu','App\Http\Controllers\API\Admin@menuView');
    Route::get('add-menu','App\Http\Controllers\API\Admin@addMenuView');
    Route::post('add-menu-action','App\Http\Controllers\API\Admin@addMenu');
    Route::get('update-menu/{id}','App\Http\Controllers\API\Admin@updateMenuView');
    Route::put('update-menu-action/{id}','App\Http\Controllers\API\Admin@updateMenu');
    Route::get('delete-menu/{id}','App\Http\Controllers\API\Admin@deleteMenu');

    /*
    |--------------------------------------------------------------------------
    | Role Management 
    |--------------------------------------------------------------------------
    |
    */

    Route::get('role-list','App\Http\Controllers\API\Admin@roleView');
    Route::get('add-role','App\Http\Controllers\API\Admin@addRoleView');
    Route::post('add-role-action','App\Http\Controllers\API\Admin@addRole');
    Route::get('update-role/{id}','App\Http\Controllers\API\Admin@updateRoleView');
    Route::put('update-role-action/{id}','App\Http\Controllers\API\Admin@updateRole');
    Route::get('delete-role/{id}','App\Http\Controllers\API\Admin@deleteRole');

    /*
    |--------------------------------------------------------------------------
    | Category Management 
    |--------------------------------------------------------------------------
    |
    */

    Route::get('category-list','App\Http\Controllers\API\Admin@categoryView');
    Route::get('add-category','App\Http\Controllers\API\Admin@addCategoryView');
    Route::get('add-category-action','App\Http\Controllers\API\Admin@addCategory');
    Route::get('update-category/{id}','App\Http\Controllers\API\Admin@updateCategoryView');
    Route::put('update-category-action/{id}','App\Http\Controllers\API\Admin@updateCategory');
    Route::get('delete-category/{id}','App\Http\Controllers\API\Admin@deleteCategory');

    /*
    |--------------------------------------------------------------------------
    | Product Supply Management 
    |--------------------------------------------------------------------------
    |
    */

    Route::get('supply-list','App\Http\Controllers\API\Admin@supplyList');
    Route::get('add-supply','App\Http\Controllers\API\Admin@addSupplyView');
    Route::post('add-supply-action','App\Http\Controllers\API\Admin@addSupply');
    Route::get('update-supply/{id}','App\Http\Controllers\API\Admin@updateSupplyView');
    Route::put('update-supply-action/{id}','App\Http\Controllers\API\Admin@updateSupply');
    Route::get('delete-supply/{id}','App\Http\Controllers\API\Admin@deleteSupply');


    /*
    |--------------------------------------------------------------------------
    | Deposits
    |--------------------------------------------------------------------------
    |
    */

    Route::get('total-credit','App\Http\Controllers\API\Admin@investment');
    Route::post('deposit-action','App\Http\Controllers\API\Admin@deposit');
    Route::get('update-deposit/{id}','App\Http\Controllers\API\Admin@updateDepositView');
    Route::put('update-deposit-action/{id}','App\Http\Controllers\API\Admin@updateDeposit');
    Route::get('delete-deposit/{id}','App\Http\Controllers\API\Admin@deleteDeposit');

    /*
    |--------------------------------------------------------------------------
    | Expenses 
    |--------------------------------------------------------------------------
    |
    */

    Route::get('total-expense','App\Http\Controllers\API\Admin@expense');
    Route::post('new-expense-action','App\Http\Controllers\API\Admin@newExpense');
    Route::get('update-expense/{id}','App\Http\Controllers\API\Admin@updateExpenseView');
    Route::put('update-expense-action/{id}','App\Http\Controllers\API\Admin@updateExpense');
    Route::get('delete-expense/{id}','App\Http\Controllers\API\Admin@deleteExpense');

    /*
    |--------------------------------------------------------------------------
    | Lends  
    |--------------------------------------------------------------------------
    |
    */

    Route::get('total-lend','App\Http\Controllers\API\Admin@lend');
    Route::post('new-lend-action','App\Http\Controllers\API\Admin@newLend');
    Route::get('update-lend/{id}','App\Http\Controllers\API\Admin@updateLendView');
    Route::put('update-lend-action/{id}','App\Http\Controllers\API\Admin@updateLend');
    Route::get('delete-lend/{id}','App\Http\Controllers\API\Admin@deleteLend');


    /*
    |--------------------------------------------------------------------------
    | Sales
    |--------------------------------------------------------------------------
    |
    */

    Route::get('total-sell','App\Http\Controllers\API\Sales@sell');
    Route::get('new-sell','App\Http\Controllers\API\Sales@newSellView');
    Route::post('new-sell-action','App\Http\Controllers\API\Sales@newSell');
    Route::get('update-sell/{id}','App\Http\Controllers\API\Sales@updateSellView');
    Route::put('update-sell-action/{id}','App\Http\Controllers\API\Sales@updateSell');
    Route::get('delete-sell/{id}','App\Http\Controllers\API\Sales@deleteSell');

    /*
    |--------------------------------------------------------------------------
    | Refunds
    |--------------------------------------------------------------------------
    |
    */

    Route::get('total-refund','App\Http\Controllers\API\Sales@refund');
    Route::get('new-refund','App\Http\Controllers\API\Sales@newRefundView');
    Route::post('new-refund-action','App\Http\Controllers\API\Sales@newRefund');
    Route::get('update-refund/{id}','App\Http\Controllers\API\Sales@updateRefundView');
    Route::put('update-refund-action/{id}','App\Http\Controllers\API\Sales@updateRefund');
    Route::get('delete-refund/{id}','App\Http\Controllers\API\Sales@deleteRefund');

    /*
    |--------------------------------------------------------------------------
    | API Routes End
    |--------------------------------------------------------------------------
    |
    */
});


