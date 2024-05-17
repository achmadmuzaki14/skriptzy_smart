<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <div class="mt-4 row">
                <div class="col-12">
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <script>
                                Alert.toast('{{ $error }}','error');
                            </script>
                        @endforeach
                    @endif
                    {{-- <div class="alert alert-dark text-sm" role="alert">
                        <strong>Add, Edit, Delete features are not functional!</strong> This is a
                        <strong>PRO</strong> feature ! Click <a href="#" target="_blank" class="text-bold">here</a>
                        to see the <strong>PRO</strong> product!
                    </div> --}}
                    <div class="card">
                        <div class="pb-0 card-header">
                            <div class="row">
                                <div class="col-6">
                                    <h5 class="">Kriteria Management</h5>
                                    <p class="mb-0 text-sm">
                                        Here you can manage kriteria.
                                    </p>
                                </div>
                                <div class="col-6 text-end">
                                    <!-- need penyesuaian -->
                                    @if (auth()->user()->role == 'pembimbing_weboender' || auth()->user()->role == 'super_admin')
                                        <a href="{{ route('criteria.weboender.create') }}" class="btn btn-dark btn-primary">
                                            <i class="fas fa-user-plus me-2"></i> Tambah Kriteria
                                        </a>
                                    @endif
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
                                        <th
                                            class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            No</th>
                                        <th
                                            class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            Nama</th>
                                        <th
                                            class="text-left text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                            Komunitas</th>
                                        @if (auth()->user()->role == 'super_admin')
                                            <th
                                                class="text-center text-uppercase font-weight-bold bg-transparent border-bottom text-secondary">
                                                Action</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($Criteria as $criteria)
                                      <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $criteria->name }}</td>
                                        <td>{{ $criteria->community->name }}</td>
                                        @if (auth()->user()->role == 'super_admin')
                                            <td>
                                                <a href="{{ route('criteria.edit', $criteria->id) }}" class="btn btn-warning btn-sm"><i class=" mx-1 fas fa-pen"></i>Edit</a>
                                                <a href="{{ route('criteria.destroy', $criteria->id) }}" class="btn btn-danger btn-sm"
                                                    data-confirm-delete="true"><i class="fas fa-eye"></i>Delete</a>
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

