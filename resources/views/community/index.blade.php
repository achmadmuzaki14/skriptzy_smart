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
                                    <h5 class="">Community Management</h5>
                                    <p class="mb-0 text-sm">
                                        Here you can manage community.
                                    </p>
                                </div>
                                @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'pembimbing')
                                <div class="col-6 text-end">
                                    <a href="{{ route('community.create') }}" class="btn btn-dark btn-primary">
                                        <i class="fas fa-user-plus me-2"></i> Tambah Komunitas
                                    </a>
                                </div>
                                @endif
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
                        <div class="table-responsive px-3">
                            <table id="tables" class="table text-secondary">
                                <thead>
                                    <tr>
                                        <th class="text-center"
                                            class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            No</th>
                                        <th
                                            class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            Nama</th>
                                        @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'pembimbing')
                                            <th
                                                class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Community as $community)
                                      <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td>{{ $community->name }}</td>
                                        @if (auth()->user()->role == 'super_admin' || auth()->user()->role == 'pembimbing')
                                            <td class="text-center">
                                            <a href="{{ route('community.edit', $community->id) }}" class="btn btn-warning btn-sm"><i class=" mx-1 fas fa-pen"></i>Edit</a>
                                            <a href="{{ route('community.destroy', $community->id) }}" class="btn btn-danger btn-sm"
                                                data-confirm-delete="true"><i class="fas fa-trash fa-sm mx-1"></i>Delete</a>
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

<script src="https://cdn.datatables.net/2.0.7/js/dataTables.js"></script>
<script>
    $(document).ready(function() {
        $('#tables').DataTable({
            searching: true, // Aktifkan fitur pencarian
            scrollX: false
        });
    });
</script>
