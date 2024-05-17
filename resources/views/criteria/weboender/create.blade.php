<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <div class="top-0 bg-cover z-index-n1 min-height-100 max-height-200 h-25 position-absolute w-100 start-0 end-0"
            style="background-image: url('../../../../assets/img/header-blue-purple.jpg'); background-position: bottom;">
        </div>
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid ">
            <form action={{ route('criteria.weboender.store') }} method="POST">
                @csrf
                {{-- @method('POST') --}}
                {{-- <div class="mt-5 mb-5 mt-lg-9 row justify-content-center"> --}}
                <div class="mt-5 mt-lg-9 row justify-content-center">
                    <div class="col-lg-9 col-12">
                        {{-- <div class="card card-body" id="profile">
                            <img src="../../../../assets/img/header-orange-purple.jpg" alt="pattern-lines"
                                class="top-0 rounded-2 position-absolute start-0 w-100 h-100">

                            <div class="row z-index-2 justify-content-center align-items-center">
                                <div class="col-sm-auto col-4">
                                    <div class="avatar avatar-xl position-relative">
                                        <img src="../../assets/img/team-2.jpg" alt="bruce"
                                            class="w-100 h-100 object-fit-cover border-radius-lg shadow-sm"
                                            id="preview">
                                    </div>
                                </div>
                                <div class="col-sm-auto col-8 my-auto">
                                    <div class="h-100">
                                        <h5 class="mb-1 font-weight-bolder">
                                            {{ auth()->user()->name }}
                                        </h5>
                                        <p class="mb-0 font-weight-bold text-sm">
                                            CEO / Co-Founder
                                        </p>
                                    </div>
                                </div>
                                <div class="col-sm-auto ms-sm-auto mt-sm-0 mt-3 d-flex">
                                    <div class="form-check form-switch ms-2">
                                        <input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault23"
                                            checked onchange="visible()">
                                    </div>
                                    <label class="text-white form-check-label mb-0">
                                        <small id="profileVisibility">
                                            Switch to invisible
                                        </small>
                                    </label>
                                </div>
                            </div>
                        </div> --}}
                    </div>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-9 col-12">
                        @if (session('error'))
                            <div class="alert alert-danger" role="alert" id="alert">
                                {{ session('error') }}
                            </div>
                        @endif
                        @if (session('success'))
                            <div class="alert alert-success" role="alert" id="alert">
                                {{ session('success') }}
                            </div>
                        @endif
                    </div>
                </div>
                <div class="mb-5 row justify-content-center">
                    <div class="col-lg-9 col-12 ">
                        <div class="card " id="basic-info">
                            <div class="card-header">
                                <h5>Tambah Kriteria</h5>
                            </div>
                            <div class="pt-0 card-body">
                                <div class="input-name-criteria">
                                    <label for="name">Nama</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Masukkan nama kriteria">
                                    @error('name')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-id-community-select">
                                    <label for="author">Nama Komunitas</label>
                                    <select class="form-control" name="community_id" id="community_id" style="width: 100%"
                                        value="{{ old('community_id') }}">
                                        <option value="">- Pilih Komunitas -</option>
                                        @foreach ($communities as $community)
                                        <option value="{{ $community->id }}"
                                            {{ old('community_id') == $community->id ? "selected" : "" }}>
                                            {{ $community->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('community_id') <span class="text-danger">{{ $message }}</span> @enderror
                                </div>
                                <div class="input-priority-criteria">
                                    <label for="location">Urutan Prioritas</label>
                                    <input type="number" step="0.0001" name="priority" id="priority"
                                        placeholder="Masukkan Urutan Prioritas Kriteria"
                                        class="form-control">
                                    @error('location')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <button type="submit" class="mt-3 mb-0 btn btn-primary btn-sm float-end">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <x-app.footer />
        </div>
    </main>

</x-app-layout>
