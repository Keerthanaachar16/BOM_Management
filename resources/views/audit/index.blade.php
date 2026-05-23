<x-app-layout>

<div class="container mt-5">

    <div class="card shadow">

        <div class="card-header bg-dark text-white">

            <h4>Audit Trail</h4>

        </div>

        <div class="card-body">

            <form method="GET"
                  action="{{ route('audit.index') }}"
                  class="mb-3">

                <div class="row">

                    <div class="col-md-4">

                        <input type="text"
                               name="search"
                               class="form-control"
                               placeholder="Search Audit"
                               value="{{ request('search') }}">

                    </div>

                    <div class="col-md-2">

                        <button class="btn btn-dark">

                            Search

                        </button>

                    </div>

                </div>

            </form>

            <table class="table table-bordered">

                <thead class="table-dark">

                    <tr>

                        <th>User</th>

                        <th>Action</th>

                        <th>Date & Time</th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($audits as $audit)

                    <tr>

                        <td>

                            {{ $audit->user->name ?? 'System' }}

                        </td>

                        <td>

                            {{ $audit->action }}

                        </td>

                        <td>

                            {{ $audit->created_at }}

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3"
                            class="text-center text-danger">

                            No Audit Records Found

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

            {{ $audits->links() }}

        </div>

    </div>

</div>

</x-app-layout>