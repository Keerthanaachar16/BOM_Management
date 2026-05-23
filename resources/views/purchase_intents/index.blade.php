<x-app-layout>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-warning">

            <h4>Purchase Intent Management</h4>

        </div>

        <div class="card-body">
            <form method="GET" action="{{ route('purchase.intent.index') }}" class="mb-3">

                <div class="row">

                    <div class="col-md-4">

                        <input type="text" name="search" class="form-control" placeholder="Search Purchase Intent" value="{{ request('search') }}">

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-warning"> Search</button>

                    </div>

                </div>

            </form>

            <table class="table table-bordered">

                <thead>

                    <tr>

                        <th>Item Code</th>

                        <th>Description</th>

                        <th>Required Qty</th>

                        <th>Available Qty</th>

                        <th>Shortfall Qty</th>

                        <th>Status</th>

                        <th>Action</th>

                    </tr>

                </thead>

                <tbody>

                    @foreach($purchaseIntents as $intent)

                    <tr>

                        <td>
                            {{ $intent->item_code }}
                        </td>

                        <td>
                            {{ $intent->description }}
                        </td>

                        <td>
                            {{ $intent->required_quantity }}
                        </td>

                        <td>
                            {{ $intent->available_quantity }}
                        </td>

                        <td>
                            {{ $intent->shortfall_quantity }}
                        </td>

                        <td>

                            @if($intent->status == 'PENDING')

                                <span class="badge bg-danger">PENDING</span>

                            @elseif($intent->status == 'ACKNOWLEDGED')

                                <span class="badge bg-warning text-dark"> ACKNOWLEDGED</span>

                            @elseif($intent->status == 'PO_RAISED')

                                <span class="badge bg-success">PO_RAISED</span>

                            @endif

                        </td>

                        <td>

                            @if($intent->status == 'PENDING')

                                <form method="POST" action="{{ route('purchase.intent.status', $intent->id) }}">

                                    @csrf

                                    <input type="hidden" name="status" value="ACKNOWLEDGED">

                                    <button type="submit" class="btn btn-warning btn-sm"> ACKNOWLEDGED</button>

                                </form>

                            @elseif($intent->status == 'ACKNOWLEDGED')

                                <form method="POST" action="{{ route('purchase.intent.status', $intent->id) }}">

                                    @csrf

                                    <input type="hidden" name="status" value="PO_Raised">

                                    <button type="submit" class="btn btn-success btn-sm"> PO_RAISED </button>

                                </form>

                            @else

                                <span class="badge bg-secondary">Completed</span>

                            @endif

                        </td>

                    </tr>

                    @endforeach

                </tbody>

            </table>

            {{ $purchaseIntents->links() }}

        </div>

    </div>

</div>

</x-app-layout>