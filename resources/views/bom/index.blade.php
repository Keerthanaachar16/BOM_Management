<x-app-layout>

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-header bg-primary text-white d-flex justify-content-between">

                <h4>BOM Management</h4>

                <a href="{{ route('bom.create') }}"class="btn btn-light">Upload New BOM</a>

            </div>

            <div class="card-body">

                @if(session('success'))

                    <div class="alert alert-success">

                        {{ session('success') }}

                    </div>

                @endif
                @if(session('error'))

            <div class="alert alert-danger">

                {{ session('error') }}

            </div>

            @endif

            
                <form method="GET" action="{{ route('bom.index') }}" class="mb-3">

                    <div class="row">

                        <div class="col-md-4">

                            <input type="text" name="search" class="form-control" placeholder="Search BOM Number"value="{{ request('search') }}">

                        </div>

                        <div class="col-md-2">

                            <button class="btn btn-primary">Search</button>

                        </div>

                    </div>

                </form>

                <table class="table table-bordered table-striped">

                    <thead>

                        <tr>

                            <th>BOM Number</th>

                            <th>Version</th>

                            <th>Uploaded At</th>

                            <th>Status</th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($boms as $bom)

                        <tr>

                            <td>

                                <a href="{{ route('bom.show', $bom->id) }}"> {{ $bom->bom_number }}</a>

                            </td>

                            <td>
                                {{ $bom->version }}
                            </td>

                            <td>
                                {{ $bom->uploaded_at }}
                            </td>

                            <td>

                                <span class="badge bg-danger">READ ONLY</span>

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

                {{ $boms->links() }}

            </div>

        </div>

    </div>

</x-app-layout>