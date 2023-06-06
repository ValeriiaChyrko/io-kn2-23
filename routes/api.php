<?php

use Illuminate\Support\Facades\Route;
use Symfony\Component\HttpFoundation\Response;

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


Route::middleware('auth:sanctum')->group(function () {

    // All groups
    Route::get('user', 'User\UserController@current');

    Route::group(['middleware' => 'can:view-departments'], function () {
        // Departments
        Route::delete('departments/destroy', 'DepartmentController@destroyMany');
        Route::resource('departments', 'DepartmentController')
            ->only(['index', 'store', 'update'])
            ->names('api.departments');
    });

    Route::group(['namespace' => 'Invoice', 'middleware' => 'can:view-invoices'], function () {
        // Invoices
        Route::resource('invoices', 'InvoiceController')
            ->only(['index', 'store', 'show', 'update'])
            ->names('api.invoices');
        Route::post('invoices/{invoice}/approve', 'InvoiceApproveController');

        // Invoice File
        Route::get('invoices/{invoice}/file', 'InvoiceFileController@show');
        Route::post('invoices/{invoice}/file', 'InvoiceFileController@store');

        // Invoice items
        Route::apiResource('invoices.items', 'InvoiceItemController')
            ->only(['index', 'store']);

        // Invoice licenses
        Route::apiResource('invoices.licenses', 'InvoiceLicenseController')
            ->only(['index', 'store']);
    });

    Route::group(['namespace' => 'Item', 'middleware' => 'can:view-items'], function () {
        // Items
        Route::get('items/stats', 'ItemController@stats');
        Route::get('items/user', 'ItemController@user');    //TODO: Create UserItemController
        Route::post('items/number-availability', 'ItemController@numberAvailability');
        Route::apiResource('items', 'ItemController')
            ->except(['store'])
            ->names('api.items');
        Route::post('items/{item}/copy', 'ItemCopyController');

        // Item licenses
        Route::apiResource('items.licenses', 'ItemLicenseController')
            ->only(['index', 'store']);

        // Item parts
        Route::apiResource('items.parts', 'ItemPartController')
            ->only(['index', 'store']);

        // Item repairs
        Route::apiResource('items.repairs', 'ItemRepairController')
            ->only(['index']);
    });

    Route::group(['namespace' => 'License', 'middleware' => 'can:view-licenses'], function () {
        // Licenses
        Route::resource('licenses', 'LicenseController')
            ->only(['index', 'update', 'destroy'])
            ->names('api.licenses');
        Route::post('licenses/{license}/copy', 'LicenseCopyController');

    });
    Route::group(['namespace' => 'Transfer', 'middleware' => 'can:view-transfers'], function () {
        // Transfers
        Route::patch('transfers/{transfer}/confirm', 'TransferController@confirm');
        Route::apiResource('transfers', 'TransferController')
            ->names('api.transfers');

        // Transfer File
        Route::get('transfers/{transfer}/file', 'TransferFileController@show');
        Route::post('transfers/{transfer}/file', 'TransferFileController@store');

        // Transfer items
        Route::apiResource('transfers.items', 'TransferItemController')
            ->only(['index', 'store']);

        // Transfer licenses
        Route::apiResource('transfers.licenses', 'TransferLicenseController')
            ->only(['index', 'store']);

    });

    Route::group(['middleware' => 'can:view-hardware-models'], function () {
        // HardwareModels
        Route::delete('hardware-models/destroy', 'HardwareModelController@destroyMany');
        Route::resource('hardware-models', 'HardwareModelController')
            ->only(['index', 'store', 'update'])
            ->names('api.hardware-models');
    });


    Route::group(['middleware' => 'can:view-software-models'], function () {
        // SoftwareModels
        Route::delete('software-models/destroy', 'SoftwareModelController@destroyMany');
        Route::resource('software-models', 'SoftwareModelController')
            ->only(['index', 'store', 'update'])
            ->names('api.software-models');
    });


    Route::group(['middleware' => 'can:view-providers'], function () {
        // Providers
        Route::delete('providers/destroy', 'ProviderController@destroyMany');
        Route::resource('providers', 'ProviderController')
            ->only(['index', 'store', 'update'])
            ->names('api.providers');
    });


    Route::group(['middleware' => 'can:view-statuses'], function () {
        // Statuses
        Route::delete('statuses/destroy', 'StatusController@destroyMany');
        Route::resource('statuses', 'StatusController')
            ->only(['index', 'store', 'update'])
            ->names('api.statuses');
    });

    Route::group(['middleware' => 'can:view-types'], function() {
        // Types
        Route::delete('types/destroy', 'TypeController@destroyMany');
        Route::resource('types', 'TypeController')
            ->only(['index', 'store', 'update'])
            ->names('api.types');
    });

    Route::group(['namespace' => 'User', 'middleware' => 'can:view-users'], function () {
        Route::resource('users', 'UserController')
            ->only(['index', 'store', 'update'])
            ->names('api.users');
        Route::get('users/addusers', 'UserController@addGoogleUsers');    //TODO: Rename

        // User items TODO: Refactor
        Route::apiResource('users.items', 'UserItemController')
            ->only(['index']);
    });

    Route::group(['middleware' => 'can:view-repairs'], function () {
        // Repairs
        Route::patch('repairs/completed/{repair}', 'RepairController@updateCompleted');

        Route::patch('repairs/{repair}/complete', 'RepairController@complete');
        Route::apiResource('repairs', 'RepairController')
            ->names('api.repairs');
    });

    Route::group(['namespace' => 'Role', 'middleware' => 'can:view-roles'], function () {
        // Roles
        Route::apiResource('roles', 'RoleController')
            ->only(['index', 'show', 'update'])
            ->names('api.roles');
    });

    Route::group(['namespace' => 'Permission', 'middleware' => 'can:view-permissions'], function () {
        // Roles
        Route::apiResource('permissions', 'PermissionController')
            ->only(['index'])
            ->names('api.permissions');
    });
});

Route::fallback(fn() => abort(Response::HTTP_NOT_FOUND));
