<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuditTrailController;
use App\Http\Controllers\BomManagementController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\PurchaseIntentController;


Route::get('/', function () {
    return view('welcome');
});

// Route::get('/dashboard', function () {
//     return view('dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

Route::get('/dashboard', [
    DashboardController::class,
    'index'
])->middleware([
    'auth',
    'verified'
])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';



Route::middleware(['auth'])->group(function () {

//     Route::get('/bom', [
//         BomManagementController::class,
//         'index'
//     ])->name('bom.index');

//     Route::get('/bom/create', [
//         BomManagementController::class,
//         'create'
//     ])->name('bom.create');

//     Route::post('/bom/store', [
//         BomManagementController::class,
//         'store'
//     ])->name('bom.store');

//     Route::get('/bom/{id}', [
//     BomManagementController::class,
//     'show'
// ])->name('bom.show');

/*
|--------------------------------------------------------------------------
| Engineer Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['role:Engineer'])
    ->group(function () {

        Route::resource(
            'bom',
            BomManagementController::class
        );

        Route::resource(
            'inventory',
            InventoryController::class
        );
    });

/*
|--------------------------------------------------------------------------
| Purchase Department Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['role:Purchase Department'])
    ->group(function () {

        Route::get(
            '/purchase-intents',
            [PurchaseIntentController::class, 'index']
        )->name('purchase.intent.index');

        Route::post(
            '/purchase-intent/{id}/status',
            [PurchaseIntentController::class, 'updateStatus']
        )->name('purchase.intent.status');
    });

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['role:Admin'])
    ->group(function () {

        Route::get(
            '/audit-trail',
            [AuditTrailController::class, 'index']
        )->name('audit.index');
    });





// Route::middleware('role:Admin|Store Department')
//     ->group(function () {

//     Route::get('/inventory', [
//         InventoryController::class,
//         'index'
//     ])->name('inventory.index');

// });



// Route::middleware(
//     'role:Admin|Purchase Department'
// )->group(function () {

//     Route::get('/purchase-intents', [
//         PurchaseIntentController::class,
//         'index'
//     ])->name('purchase.intent.index');

// Route::middleware(
//     'role:Admin|Engineer'
// )->group(function () {

//     Route::resource(
//         'bom',
//         BomManagementController::class
//     );

// });




// });

Route::get('/audit-trail', [AuditTrailController::class,'index'])->name('audit.index');

Route::post(
    '/purchase-intent/{id}/status',
    [PurchaseIntentController::class, 'updateStatus']
)->name('purchase.intent.status');







});


