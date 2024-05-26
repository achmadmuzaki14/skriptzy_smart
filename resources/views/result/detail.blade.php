<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="mt-4 row">
                <div class="col-12">
                    <div class="card">
                        <div class="pb-0 card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="">Hasil Perankingan</h5>
                                    <p class="mb-0 text-sm">
                                        Berikut adalah data hasil perhitungan metode SMART
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="row justify-content-center">
                            <div class="">
                                @if (session('success'))
                                    <div class="alert alert-success" role="alert" id="alert">
                                        {{ session('success') }}
                                    </div>
                                @endif
                                @if (session('error'))
                                    <div class="alert alert-danger" role="alert" id="alert">
                                        {{ session('error') }}
                                    </div>
                                @endif
                            </div>
                        </div>
                        <div class="table-responsive">
                            <table class="table text-secondary text-center">
                                <thead>
                                    <tr>
                                        <th class="text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            No</th>
                                        <th class="text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            Kriteria</th>
                                        <th class="text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                           Total Nilai Utility</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($utilityData as $criterionName => $utility)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $criterionName }}</td>
                                        <td>{{ $utility }}</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <x-app.footer />
    </main>

</x-app-layout>

<script src="{{ asset('/assets/js/plugins/datatables.js') }}"></script>
<script>
    const dataTableBasic = new simpleDatatables.DataTable("#datatable-search", {
        searchable: true,
        fixedHeight: true,
        columns: [{
            select: [2, 6],
            sortable: false
        }]
    });
</script>
