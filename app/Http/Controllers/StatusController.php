<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;

class StatusController extends Controller
{
        /**
        * Display a listing of the status.
        *
        * @return Response
        */
        public function index()
        {
            $status = Status::all();
            return new StatusResource($status);
        }
}
