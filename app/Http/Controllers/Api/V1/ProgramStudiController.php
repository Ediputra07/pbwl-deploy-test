<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ProgramStudiResource;
use App\Models\ProgramStudi;

class ProgramStudiController extends Controller
{
    public function index()
    {
        return ProgramStudiResource::collection(ProgramStudi::orderBy('nama')->get());
    }
}
