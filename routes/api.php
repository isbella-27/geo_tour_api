<?php

use App\Http\Controllers\Api\HebergementController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('hebergements', HebergementController::class);
