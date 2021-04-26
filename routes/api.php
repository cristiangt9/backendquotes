<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::apiResource('/quotes', "QuoteController");
Route::apiResource('/comments', "CommentController");

