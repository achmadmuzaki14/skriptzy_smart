<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="mt-4 row">
                <div class="col-12">
                    {{-- <div class="alert alert-dark text-sm" role="alert">
                        <strong>Add, Edit, Delete features are not functional!</strong> This is a
                        <strong>PRO</strong> feature ! Click <a href="#" target="_blank" class="text-bold">here</a>
                        to see the <strong>PRO</strong> product!
                    </div> --}}
                    <div class="card">
                        <div class="pb-0 card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="">Scoring Management</h5>
                                    <p class="mb-0 text-sm">
                                        Here you can manage score.
                                    </p>
                                </div>
                                <div class="col-6 text-end">
                                    {{-- <a href="#" class="btn btn-dark btn-primary" data-toggle="modal" data-target="#alternativeModal">
                                        <i class="fas fa-user-plus me-2"></i> Tambah Penilaian
                                    </a> --}}
                                    <button type="button" class="btn btn-dark" data-bs-toggle="modal" data-bs-target="#alternativeModal">
                                        Tambah Penilaian
                                      </button>
                                    <!-- modal select alternative -->
                                        <div class="modal fade" id="alternativeModal" tabindex="-1" role="dialog"
                                        aria-labelledby="alternativeModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                <h5 class="modal-title" id="alternativeModalLabel">Pilih Alternatif</h5>
                                                <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                  </button>
                                                </div>
                                                <div class="modal-body">
                                                <select class="form-control" id="alternativeSelect" name="alternative_id">
                                                    <option value="">Pilih Alternatif</option>
                                                    @foreach ($alternatives as $alternative_data)
                                                        <option value="{{ $alternative_data->id }}">{{ $alternative_data->name }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                                                    <button type="button" class="btn btn-primary" id="selanjutnyaBtn">Selanjutnya</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- modal select alternative -->
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
                        <div class="table-responsive p-3">
                            <table class="table text-secondary text-center" id="tables">
                                <thead>
                                    <tr>
                                        <th
                                            class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            ID</th>
                                        <th
                                            class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            Nama Penilai</th>
                                        <th
                                            class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            Nama Alternatif</th>
                                        <th
                                            class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            Score</th>
                                        @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'pembimbing')
                                            <th
                                                class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($alternative_values_data as $alternative_values)
                                      <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-start">{{ $alternative_values->user->name }}</td>
                                        <td>{{ $alternative_values->alternative->name }}</td>
                                        <td class="text-center">{{ $alternative_values->value }}</td>
                                        @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'pembimbing')
                                            <td>
                                                <a href="{{ route('scoring.edit', $alternative_values->id) }}" class="btn btn-warning btn-sm">
                                                    <i class="fas fa-pen"></i> Edit
                                                </a>
                                            <a href="#" class="btn btn-danger btn-sm">
                                                <i class="fas fa-trash fa-sm"></i> Hapus
                                            </a>
                                            </td>
                                        @endif
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
<script>
    $(document).ready(function() {
      $("#selanjutnyaBtn").click(function() {
        let alternativeId = $("#alternativeSelect").val();
        if (alternativeId) {
          $.ajax({
            url: "{{ route('alternative.get-by-community') }}",
            type: "POST",
            data: {
              _token: "{{ csrf_token() }}",
              alternative_id: alternativeId
            },
            success: function(response) {
              window.location.href = "{{ route('scoring.create') }}" + "?alternative=" +
                alternativeId
            },
            error: function(xhr, status, error) {
              console.error(xhr.responseText);
            }
          })
        }
      });
    });
  </script>

<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#tables').DataTable({
            searching: true, // Aktifkan fitur pencarian
            scrollX: false
        });
    });
</script>

{{-- <script src="/assets/js/plugins/datatables.js"></script>
<script>
    const dataTableBasic = new simpleDatatables.DataTable("#datatable-search", {
        searchable: true,
        fixedHeight: true,
        columns: [{
            select: [2, 6],
            sortable: false
        }]
    });
</script> --}}
