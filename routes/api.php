<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Property;
use App\PropertyAnalytics;
use App\AnalyticType;
use App\Http\Resources\PropertyAnalytics as ResourcesPropertyAnalytics;
use App\Http\Resources\SummaryAnalyticCollection;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Create new Property
Route::post('properties', 'ApiController@createProperty');

// Add Analytics to Property or update
Route::post('properties/{id}/', 'ApiController@updateOrCreateAnalytics');

// Get Analytics for Property
Route::get('properties/{id}/', 'ApiController@getPropertyAnlytics');

// Get summary Analytics. Field should belong to ("suburb", "state", "country")
Route::get('summary/{field}/{value}', 'ApiController@getSummaryAnlytics')->where('field', '(suburb|state|country)');