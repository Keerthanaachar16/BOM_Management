<x-app-layout>

    <div class="container mt-5">

        <div class="card shadow">

            <div class="card-header bg-dark text-white">

                <h4>BOM Upload Portal</h4>

            </div>

            <div class="card-body">

                <form action="{{ route('bom.store') }}" method="POST" enctype="multipart/form-data">

                    @csrf

                    <div class="mb-3">

                        <label class="form-label">Upload BOM Excel File</label>

                        <input type="file" name="bom_file" class="form-control" accept=".xlsx,.xls,.csv" required>

                    </div>

                    <button class="btn btn-primary">Upload BOM</button>

                </form>

            </div>

        </div>

    </div>

</x-app-layout>