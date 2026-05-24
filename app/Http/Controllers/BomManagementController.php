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

    //  public function store(Request $request)
    // {
    // $request->validate([
    //     'bom_file' => 'required|mimes:xlsx,xls,csv'
    // ]);

    // $file = $request->file('bom_file');

    // $path = $file->store(
    //     'bom_files',
    //     'public'
    // );


    // $latestBom = BomHeader::latest()->first();

    //     $nextVersion = 1;
    //     if ($latestBom) 
    //     {

    //         $currentVersion = (int) str_replace('REV-','', $latestBom->version);
    //         $nextVersion = $currentVersion + 1;
    //     }

    //     $bomHeader = BomHeader::create([

    //     'project_id' => 1,

    //     'bom_number' => 'BOM-' . time(),

    //     'version' => 'REV-' . $nextVersion,

    //     'uploaded_file' => $path,

    //     'uploaded_at' => now(),

    //     'uploaded_by' => auth()->id(),

    //     'is_locked' => true]);

    //     Excel::import(new BomImport($bomHeader),$file);

    //     ProcessBomInventoryJob::dispatch($bomHeader);

    //     AuditTrail::create([

    //     'action' =>
    //         'BOM Uploaded : '
    //         . $bomHeader->bom_number,

    //     'user_id' =>
    //         auth()->id()]);

    //     return redirect()->route('bom.index')->with('success','BOM Uploaded Successfully');
    // }


    public function store(Request $request)
{
    // VALIDATION
    

    $request->validate([

        'bom_file' => [

            'required',

            'mimes:xlsx,xls,csv',

            'max:2048'
        ]

    ], [

        'bom_file.required' =>
            'Please upload a BOM file.',

        'bom_file.mimes' =>
            'Only Excel or CSV files are allowed.',

        'bom_file.max' =>
            'File size should not exceed 2MB.'
    ]);

    //  DUPLICATE FILE CHECK
 
    $file = $request->file('bom_file');

  $existingBom = BomHeader::where(

    'original_file_name',

    $file->getClientOriginalName()

)->exists();

    if ($existingBom) {

        return back()->with(

            'error',

            'This BOM file is already uploaded.'
        );
    }

    //  STORE FILE
    $path = $file->store(

        'bom_files',

        'public'
    );

//  VERSION GENERATION

    $latestBom = BomHeader::latest()->first();

    $nextVersion = 1;

    if ($latestBom) {

        $currentVersion = (int) str_replace(

            'REV-',

            '',

            $latestBom->version
        );

        $nextVersion = $currentVersion + 1;
    }

    // CREATE BOM HEADER

    $bomHeader = BomHeader::create([

        'project_id' => 1,

        'bom_number' => 'BOM-' . time(),

        'version' => 'REV-' . $nextVersion,

        'uploaded_file' => $path,
        
        'original_file_name' =>$file->getClientOriginalName(),

        'uploaded_at' => now(),

        'uploaded_by' => auth()->id(),

        'is_locked' => true
    ]);

   
    //  EXCEL IMPORT
    try {

        Excel::import(

            new BomImport($bomHeader),

            $file
        );

    } catch (\Exception $e) {

        return back()->with(

            'error',

            'Invalid BOM structure or corrupted file.'
        );
    }

//    PROCESS INVENTORY
    
    ProcessBomInventoryJob::dispatch($bomHeader);

//  AUDIT TRAIL
   
    AuditTrail::create([

        'action' =>'BOM Uploaded : ' . $bomHeader->bom_number,

        'user_id' =>
            auth()->id()
    ]);

    return redirect()
        ->route('bom.index')->with('success','BOM Uploaded Successfully');
}

    public function show($id)
    {
        $bom = BomHeader::with([
            'lineItems.allocations'
        ])->findOrFail($id);

        return view('bom.show', compact('bom'));
    }
}