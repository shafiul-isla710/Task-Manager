<?php 

use App\Http\Controllers\API\Auth\AuthController;
use Illuminate\Support\Facades\Route; 

Route::post('/v1/register', [AuthController::class, 'register']);