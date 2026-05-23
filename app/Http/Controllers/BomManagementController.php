<?php

namespace App\Http\Controllers;

use App\Imports\BomImport;
use App\Jobs\ProcessBomInventoryJob;
use App\Models\BomHeader;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\AuditTrail;

class BomManagementController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->search;

        $boms = BomHeader::when(
                $search,
                function ($query) use ($search) {

                    $query->where( 'bom_number','like',"%{$search}%");
                }
            )
            ->latest()
            ->paginate(10);

            return view('bom.index',compact('boms','search'));
    }

    public function create()
    {
        return view('bom.upload');
    }

     public function store(Request $request)
    {
    $request->validate([
        'bom_file' => 'required|mimes:xlsx,xls,csv'
    ]);

    $file = $request->file('bom_file');

    $path = $file->store(
        'bom_files',
        'public'
    );


    $latestBom = BomHeader::latest()->first();

        $nextVersion = 1;
        if ($latestBom) 
        {

            $currentVersion = (int) str_replace('REV-','', $latestBom->version);
            $nextVersion = $currentVersion + 1;
        }

        $bomHeader = BomHeader::create([

        'project_id' => 1,

        'bom_number' => 'BOM-' . time(),

        'version' => 'REV-' . $nextVersion,

        'uploaded_file' => $path,

        'uploaded_at' => now(),

        'uploaded_by' => auth()->id(),

        'is_locked' => true]);

        Excel::import(new BomImport($bomHeader),$file);

        ProcessBomInventoryJob::dispatch($bomHeader);

        AuditTrail::create([

        'action' =>
            'BOM Uploaded : '
            . $bomHeader->bom_number,

        'user_id' =>
            auth()->id()]);

        return redirect()->route('bom.index')->with('success','BOM Uploaded Successfully');
    }

    public function show($id)
    {
        $bom = BomHeader::with([
            'lineItems.allocations'
        ])->findOrFail($id);

        return view('bom.show', compact('bom'));
    }
}