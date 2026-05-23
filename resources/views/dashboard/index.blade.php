<x-app-layout>

<div class="container mt-5">

    <h2 class="mb-4">

        BOM Management Dashboard

    </h2>

    <!-- Dashboard Cards -->

    <div class="row">

        <div class="col-md-3">

            <div class="card bg-primary text-white shadow">

                <div class="card-body">

                    <h5>Total BOMs</h5>

                    <h2>
                        {{ $bomCount }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-success text-white shadow">

                <div class="card-body">

                    <h5>Inventory Items</h5>

                    <h2>
                        {{ $inventoryCount }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-warning text-dark shadow">

                <div class="card-body">

                    <h5>Purchase Intents</h5>

                    <h2>
                        {{ $purchaseIntentCount }}
                    </h2>

                </div>

            </div>

        </div>

        <div class="col-md-3">

            <div class="card bg-danger text-white shadow">

                <div class="card-body">

                    <h5>Out Of Stock</h5>

                    <h2>
                        {{ $outOfStockCount }}
                    </h2>

                </div>

            </div>

        </div>

    </div>

    <!-- Low Stock Alerts -->

    <div class="card mt-5 shadow">

        <div class="card-header bg-danger text-white">

            <h4>

                Low Stock Alerts

            </h4>

        </div>

        <div class="card-body">

            @if($lowStockItems->count())

                <table class="table table-bordered">

                    <thead>

                        <tr>

                            <th>Item Code</th>

                            <th>Description</th>

                            <th>Shortfall Qty</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach(
                            $lowStockItems
                            as $item
                        )

                        <tr>

                            <td>
                                {{ $item->item_code }}
                            </td>

                            <td>
                                {{ $item->description }}
                            </td>

                            <td>

                                <span class="badge bg-danger">

                                    {{ $item->shortfall_quantity }}

                                </span>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            @else

                <div class="alert alert-success">

                    No Low Stock Alerts

                </div>

            @endif

        </div>

    </div>

</div>

</x-app-layout>