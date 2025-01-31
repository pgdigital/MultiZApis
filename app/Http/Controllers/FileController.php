<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FileController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke($path)
    {
        return Storage::response($path);
    }
}
