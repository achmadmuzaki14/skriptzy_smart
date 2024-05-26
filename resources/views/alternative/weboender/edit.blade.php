<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <div class="top-0 bg-cover z-index-n1 min-height-100 max-height-200 h-25 position-absolute w-100 start-0 end-0"
            style="background-image: url('../../../../assets/img/header-blue-purple.jpg'); background-position: bottom;">
        </div>
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid ">
            <form action={{ route('alternative.update', $alternative->id) }} method="POST">
                @csrf
                @method('PUT')
                <div class="mt-5 mt-lg-9 row justify-content-center">
                    <div class="col-lg-9 col-12">
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
                                <h5>Tambah Alternatif</h5>
                            </div>
                            <div class="pt-0 card-body">
                                <div class="input-name-criteria">
                                    <label for="name">Nama</label>
                                    <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Masukkan nama alternatif" value="{{ $alternative->name }}">
                                    @error('name')
                                        <span class="text-danger text-sm">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="input-id-community-select">
                                    <label for="author">Nama Komunitas</label>
                                    <select class="form-control" name="community_id" id="community_id" style="width: 100%">
                                        <option value="">- Pilih Komunitas -</option>
                                        @foreach ($communities as $community)
                                        <option value="{{ $community->id }}" {{ $alternative->community_id == $community->id ? "selected" : "" }}>
                                            {{ $community->name }}</option>
                                        @endforeach
                                    </select>
                                    @error('community_id') <span class="text-danger">{{ $message }}</span> @enderror
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
