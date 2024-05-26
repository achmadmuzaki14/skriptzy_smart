<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
        <div class="top-0 bg-cover z-index-n1 min-height-100 max-height-200 h-25 position-absolute w-100 start-0 end-0"
            style="background-image: url('../../../../assets/img/header-blue-purple.jpg'); background-position: bottom;">
        </div>
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid">
            <form action="{{ route('scoring.update', $alternativeValue->id) }}" method="POST">
                @csrf
                @method('PUT')
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
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
                    <div class="col-lg-9 col-12">
                        <div class="card" id="basic-info">
                            <div class="card-header">
                                <h5>Edit Penilaian</h5>
                            </div>
                            <div class="pt-0 card-body">
                                <div class="form-group row">
                                    <label for="alternative_id" class="col-sm-2 col-form-label">Alternatif</label>
                                    <div class="col-sm-12">
                                        <select class="form-control" id="alternative_id" name="alternative_id">
                                            @foreach ($alternatives as $alternative)
                                                <option value="{{ $alternative->id }}"
                                                    {{ $alternative->id == $alternativeValue->alternative_id ? 'selected' : '' }}>
                                                    {{ $alternative->name }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                {{-- @foreach ($criterias as $criteria) --}}
                                    <div class="input-name-criteria">
                                        <label for="{{ $criterias->first()->name }}">{{ $criterias->first()->name }}</label>
                                        <input type="number" name="value" id="criteria-{{ $criterias->first()->id  }}"
                                            class="form-control" placeholder="Masukkan nilai kriteria"
                                            value="{{ old($criterias->first()->id , $alternativeValue->value) }}">
                                        @error($criterias->first()->id )
                                            <span class="text-danger text-sm">{{ $message }}</span>
                                        @enderror
                                    </div>
                                {{-- @endforeach --}}
                                <button type="submit" class="mt-3 mb-0 btn btn-primary btn-sm float-end">Submit</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <x-app.footer />
    </main>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</x-app-layout>
