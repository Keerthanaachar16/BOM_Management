<x-app-layout>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-success text-white">

            <h4>Inventory Management</h4>

        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('inventory.index') }}" class="mb-3">

                <div class="row">

                    <div class="col-md-4">

                        <input type="text" name="search" class="form-control" placeholder="Search Inventory" value="{{ request('search') }}">

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-success"> Search</button>

                    </div>

                </div>

            </form>

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Item Code</th>

                        <th>Description</th>

                        <th>Available Qty</th>

                        <th>UOM</th>

                        <th>Location</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($inventories as $inventory)

                    <tr>

                        <td>
                            {{ $inventory->item_code }}
                        </td>

                        <td>
                            {{ $inventory->description }}
                        </td>

                        <td>
                            {{ $inventory->available_quantity }}
                        </td>

                        <td>
                            {{ $inventory->uom }}
                        </td>

                        <td>
                            {{ $inventory->location }}
                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            {{ $inventories->links() }}

        </div>

    </div>

</div>

</x-app-layout>