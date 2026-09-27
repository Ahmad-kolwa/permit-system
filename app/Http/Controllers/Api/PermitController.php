<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Permit;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;


class PermitController extends Controller
{

//Store permits but generate unique permit code
    public function store(Request $request)
    {
        // 1. Validate request
        $validated = $request->validate([
            'park_id' => 'required|exists:parks,id',
            'visitor_name' => 'required|string|max:255',
            'visit_date' => 'required|date',
            'amount' => 'required|numeric|min:0',
        ]);

        // 2. Generate unique permit code
        do {
            $permitCode = 'PRM-' . date('Y') . '-' . strtoupper(Str::random(6));
        } while (Permit::where('permit_code', $permitCode)->exists());

        // 3. Create permit
        $permit = Permit::create([
            'user_id' => $request->user()->id,
            'park_id' => $validated['park_id'],
            'visitor_name' => $validated['visitor_name'],
            'visit_date' => $validated['visit_date'],
            'amount' => $validated['amount'],
            'permit_code' => $permitCode,
            'status' => 'pending',
        ]);

        // 4. Return response
        return response()->json([
            'message' => 'Permit created successfully',
            'data' => $permit
        ], 201);
    }

    //normal user see their only permits with status cancelled while other show all cancelled permits
public function cancelled()
{
    $user = auth()->user();

    $query = Permit::with('park')
        ->where('status', 'cancelled');

    // Normal user sees only their own cancelled permits
    if ($user->role !== 'admin') {
        $query->where('user_id', $user->id);
    }

    $permits = $query->get();

    return response()->json([
        'success' => true,
        'data' => $permits,
    ]);
}


  
    //Admin can view any permit, while a normal user can only view their own permit.
    //This method finds a permit by its permit code and controls who can view it.
    //GET /api/v1/permits/PRM-2026-U2DYYX
    public function show($code)
{
    $permit = Permit::where(
        'permit_code',
        $code
    )->firstOrFail();

    if (
        auth()->user()->role !== 'admin'
        &&
        $permit->user_id !== auth()->id()
    ) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 403);
    }

    return response()->json($permit);
}
///////////////////////////////OR////////////////////////////////////////
public function show($code)
{
    $user = auth()->user();

    $permit = Permit::with('park')
        ->where('permit_code', $code)
        ->firstOrFail();

    if (
        $user->role === 'admin' ||
        $permit->user_id === $user->id
    ) {
        return response()->json($permit);
    }



    return response()->json([
        'message' => 'Unauthorized'
    ], 403);
}

public function destroy($id)
{
    $permit = Permit::findOrFail($id);

    if ($permit->status === 'paid') {
        return response()->json([
            'message' => 'Paid permit cannot be deleted'
        ], 400);
    }

    $permit->delete();

    return response()->json([
        'message' => 'Deleted successfully'
    ]);
}


public function pay(Request $request, $code)
{
    // 1. Validate payment information
    $validated = $request->validate([
        'amount' => 'required|numeric|min:1',
        'payment_reference' => 'required|string|max:255',
    ]);

    // 2. Find the permit
    $permit = Permit::where(
        'permit_code',
        $code
    )->firstOrFail();

    // 3. Check authorization
    if (
        auth()->user()->role !== 'admin'
        &&
        $permit->user_id !== auth()->id()
    ) {
        return response()->json([
            'message' => 'Unauthorized'
        ], 403);
    }

    // 4. Prevent duplicate payment
    if ($permit->status === 'paid') {
        return response()->json([
            'message' => 'Permit already paid'
        ], 400);
    }

    // 5. Create payment
    $payment = Payment::create([
        'permit_id' => $permit->id,
        'amount' => $validated['amount'],
        'payment_reference' => $validated['payment_reference'],
        'payment_date' => now(),
    ]);

    // 6. Change permit status
    $permit->update([
        'status' => 'paid'
    ]);

    // 7. Return response
    return response()->json([
        'message' => 'Payment successful',
        'payment' => $payment
    ], 201);
}
// public function pay(Request $request, $code)
// {
//     $request->validate([
//         'amount' => 'required|numeric',
//         'payment_reference' => 'required'
//     ]);

//     $permit = Permit::where(
//         'permit_code',
//         $code
//     )->firstOrFail();

//     if ($permit->status === 'paid') {
//         return response()->json([
//             'message' => 'Permit already paid'
//         ], 400);
//     }

//     Payment::create([
//         'permit_id' => $permit->id,
//         'amount' => $request->amount,
//         'payment_reference' => $request->payment_reference,
//         'payment_date' => now()
//     ]);

//     $permit->update([
//         'status' => 'paid'
//     ]);

//     return response()->json([
//         'message' => 'Payment successful'
//     ]);
// }

//show all permits by using date but Normal user sees only their own permits
//GET /api/v1/permits?date=2026-08-20
public function index(Request $request)
{
    $user = $request->user();

    $query = Permit::with('park');

    // Normal user sees only their own permits
    if ($user->role !== 'admin') {
        $query->where('user_id', $user->id);
    }

    // Filter by visit date
    if ($request->filled('date')) {
        $query->whereDate('visit_date', $request->date);
    }

    $permits = $query->latest()->get();

    return response()->json([
        'success' => true,
        'data' => $permits
    ]);
}

public function revenue()
{
    return response()->json([
        'total_paid' =>
            Payment::sum('amount'),

        'total_permits' =>
            Permit::where(
                'status',
                'paid'
            )->count()
    ]);
}

public function cancel($code)
{
    $permit = Permit::with('park')
        ->where('permit_code', $code)
        ->firstOrFail();

    if ($permit->status === 'cancelled') {
        return response()->json([
            'success' => false,
            'message' => 'Permit is already cancelled.'
        ], 400);
    }

    $permit->update([
        'status' => 'cancelled'
    ]);

    return response()->json([
        'success' => true,
        'message' => 'Permit cancelled successfully'
    ]);
}
} 
