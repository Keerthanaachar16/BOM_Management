<?php

namespace App\Http\Controllers;

use App\Models\AuditTrail;
use Illuminate\Http\Request;

class AuditTrailController extends Controller
{
    public function index(Request $request)
{
    $search = $request->search;

    $audits = AuditTrail::with('user')

        ->when($search, function ($query) use ($search) {

            $query->where(
                'action',
                'like',
                "%{$search}%"
            );
        })

        ->latest()

        ->paginate(10);

    return view(
        'audit.index',
        compact(
            'audits',
            'search'
        )
    );
}
}