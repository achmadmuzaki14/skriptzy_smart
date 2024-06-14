<x-app-layout>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">

        <div class="top-0 bg-cover z-index-n1 min-height-100 max-height-200 h-25 position-absolute w-100 start-0 end-0"
            style="background-image: url('../../../../assets/img/header-blue-purple.jpg'); background-position: bottom;">
        </div>
        <x-app.navbar />
        <div class="px-5 py-4 container-fluid ">
            <form action={{ route('scoring.store') }} method="POST">
                @csrf
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
                    <div class="col-lg-9 col-12 ">
                        <div class="card " id="basic-info">
                            <div class="card-header">
                                <h5>Tambah Penilaian</h5>
                            </div>
                            <div class="pt-0 card-body">
                                <div class="form-group row">
                                    <label for="alternative_id">Alternatif</label>
                                    <div class="col-sm-12">
                                      <select class="form-control" id="alternative_id" name="alternative_id">
                                        @foreach ($alternatives as $alternative)
                                          <option value="{{ $alternative->id }}">{{ $alternative->name }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                                <div class="form-group row">
                                    <label for="alternative_id">Komunitas</label>
                                    <div class="col-sm-12">
                                      <select class="form-control">
                                        @foreach ($alternatives as $alternative)
                                          <option value="{{ $alternative->community_id }}">{{ $alternative->community->name }}</option>
                                        @endforeach
                                      </select>
                                    </div>
                                  </div>
                            @foreach ($criterias as $criteria)
                            <div class="input-name-criteria">
                                <label for="name">{{ $criteria->name }}</label>
                                <input type="number" name="{{ $criteria->id }}" id="name" class="form-control"
                                placeholder="Masukkan nilai kriteria">
                                @error('name')
                                    <span class="text-danger text-sm">{{ $message }}</span>
                                @enderror
                            </div>
                            @endforeach
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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function() {
          var alternativeId = $('#alternative_id').val();
          var userId = {{ auth()->user()->id }}; // Replace with actual user ID retrieval
          console.log(alternativeId)

          if (alternativeId) {
            $.ajax({
              url: "{{ route('scoring.check-exist') }}", // Define a route for checking existence
              type: 'POST',
              data: {
                _token: '{{ csrf_token() }}',
                alternative_id: alternativeId,
                user_id: userId
              },
              success: function(response) {
                console.log(response)
                if (response.exists) {
                  Swal.fire({
                    title: 'Perhatian!',
                    text: 'Penilaian untuk alternatif ini sudah ada!',
                    icon: 'warning',
                  }).then((result) => {
                    window.location.href =
                      "{{ route('scoring.index', ['communityName' => 'all']) }}"; // Need Penyesuaian
                  });
                  $('#submitButton').prop('disabled',
                    true); // Disable submit button
                } else {
                  $('#submitButton').prop('disabled',
                    false); // Enable submit button
                }
              },
              error: function(error) {
                console.error(error); // Handle AJAX errors
              }
            });
          }
        });
      </script>

</x-app-layout>
