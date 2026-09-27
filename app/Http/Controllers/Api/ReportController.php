<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Payment;
use App\Models\Permit;

class ReportController extends Controller
{
    public function revenue()
    {
        return response()->json([
            'total_paid' => Payment::sum('amount'),
            'total_permits' => Permit::where('status', 'paid')->count()
        ]);
    }
}