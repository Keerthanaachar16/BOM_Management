<?php

namespace App\Imports;

use App\Models\BomHeader;
use App\Models\BomLineItem;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;

class BomImport implements ToCollection
{
    protected $bomHeader;

    public function __construct(BomHeader $bomHeader)
    {
        $this->bomHeader = $bomHeader;
    }

    public function collection(Collection $rows)
    {
        foreach ($rows as $index => $row) {

            /*
            Excel actual data starts after header rows
            */

            if ($index < 8) {
                continue;
            }

            /*
            Skip empty rows
            */

            if (
                empty($row[0]) &&
                empty($row[1])
            ) {
                continue;
            }

            /*
            Skip section heading rows
            */

            if (
                str_contains(
                    strtoupper($row[1] ?? ''),
                    'ASSEMBLY'
                )
            ) {
                continue;
            }

            BomLineItem::create([

                'bom_header_id' => $this->bomHeader->id,

                /*
                Excel Mapping
                */

                'item_code' => trim($row[0] ?? ''),

                'part_number' => trim($row[2] ?? ''),

                'description' => trim($row[1] ?? ''),

                'uom' => trim($row[6] ?? ''),

                'required_quantity' =>
                    is_numeric($row[5] ?? null)
                    ? $row[5]
                    : 0,

                'specification' =>
                    trim($row[3] ?? ''),

                'allocated_to' => 'STORE'
            ]);
        }
    }
}