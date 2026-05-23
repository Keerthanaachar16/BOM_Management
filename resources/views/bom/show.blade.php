<x-app-layout>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            <h4>

                BOM Details : {{ $bom->bom_number }}

            </h4>

        </div>

        <div class="card-body">

            <div class="mb-4">

                <strong>Version :</strong>
                {{ $bom->version }}

                <br>

                <strong>Uploaded At :</strong>
                {{ $bom->uploaded_at }}

            </div>

            <table class="table table-bordered table-striped">

                <thead class="table-dark">

                    <tr>

                        <th>Item Code</th>

                        <th>Description</th>

                        <th>Required Qty</th>

                        <th>UOM</th>

                        <th>Status</th>

                        <th>Allocation</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($bom->lineItems as $item)

                    <tr>

                        <td>
                            {{ $item->item_code }}
                        </td>

                        <td>
                            {{ $item->description }}
                        </td>

                        <td>
                            {{ $item->required_quantity }}
                        </td>

                        <td>
                            {{ $item->uom }}
                        </td>

                        <td>

                            @if($item->inventory_status == 'IN_STOCK')

                                <span class="badge bg-success">IN STOCK</span>

                            @elseif( $item->inventory_status == 'PARTIAL_STOCK')

                                <span class="badge bg-warning text-dark">PARTIAL STOCK</span>

                            @else

                                <span class="badge bg-danger">OUT OF STOCK</span>

                            @endif

                        </td>

                        <td>

                            @forelse($item->allocations as $allocation)

                                <div>

                                    Qty:
                                    {{
                                        $allocation
                                        ->allocated_quantity
                                    }}

                                </div>

                            @empty

                                <span class="text-danger">No Allocation</span>

                            @endforelse

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

</x-app-layout>