<?php

namespace App\Http\Controllers;

use App\Models\AlternativeValue;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class AlternativeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($communityName)
    {
        $title = 'Delete Score?';
        $text = 'Apakah anda yakin ingin menghapus data ini?';
        confirmDelete($title, $text, 'alternativeValue.destroy');
        // dd($communityName);
        if (($communityName == 'all') ) {
            if (auth()->user()->role == 'super_admin') {
                $alternatives = Alternative::latest()->get();
                $alternative_values_data = AlternativeValue::query()->get();
                return view('scoring.index', compact(['alternative_values_data', 'alternatives']));
            }
            // } else {
            //     dd('hai');
            //     Alert::toast('Akses Dilarang!', 'error');
            //     return redirect()->back();
            // }
        }else {
            // dd('hao');
            if (auth()->user()->role == 'user') {
                $alternatives = Alternative::latest()->get();
                $alternative_values_data = AlternativeValue::query()->get();
                return view('scoring.index', compact('alternative_values_data', 'alternatives'));
            }else if(auth()->user()->community->name == $communityName){
                // Dapatkan ID komunitas berdasarkan nama dari URL
                $communityId = Community::where('name', $communityName)->value('id');

                // Dapatkan alternatif nilai yang terkait dengan ID komunitas
                // $alternatives = Alternative::latest()->get();
                $alternatives = Alternative::where('name', $communityName)->get();
                $alternative_values_data = AlternativeValue::whereHas('alternative.community', function ($query) use ($communityId) {
                    $query->where('communities.id', $communityId);
                })->with(['alternative', 'user'])->latest()->get();

                return view('scoring.index', compact('alternative_values_data', 'alternatives'));
            }else{
                Alert::toast('Akses Dilarang!', 'error');
                return redirect()->back();
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        if (auth()->user()->role == 'pembimbing' || auth()->user()->role == 'super_admin') {
            // $communities = Community::latest()->get();
            // return view('scoring.create', compact(['communities']));

            $current_user = auth()->user();
            $alternative_id = $request->query('alternative');
            $alternatives = Alternative::where('id', $alternative_id)->get();
            $community_id = Alternative::where('id', $alternative_id)->first()->community_id;
            $criterias = Criteria::where('community_id', $community_id)->get();
            $current_user = auth()->user();
            return view('scoring.create', compact('alternatives', 'criterias', 'current_user'));
        }else{
            Alert::toast('Akses Dilarang!', 'error');
            return redirect()->back();
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        try {
            // Inisialisasi array untuk menyimpan data nilai kriteria
            $scores = [];

            // Iterasi melalui setiap kriteria dan nilai yang diterima dari formulir
            foreach ($request->except('_token', 'alternative_id') as $criteriaId => $value) {
                // Jika criteriaId adalah 'user_id' atau indeks 0, lewati iterasi ini
                if ($criteriaId === 'user_id' || $criteriaId === 0) {
                    continue;
                }

                // Buat array untuk menyimpan data nilai kriteria
                $scoreData = [
                    'value' => $value,
                    'alternative_id' => $request->alternative_id,
                    'criteria_id' => $criteriaId,
                    'user_id' => $request->user_id,
                ];

                // Tambahkan data nilai kriteria ke dalam array scores
                $scores[] = $scoreData;
            }

            // Simpan data nilai kriteria ke dalam database
            AlternativeValue::insert($scores);

            $penilaian = app(ScoreResultController::class)->calculateRankingAndStore();
            if ($penilaian) {
                // Berhasil menyimpan data
                Alert::success('Berhasil', 'Data berhasil disimpan');
                return redirect()->route('scoring.index',  ['communityName' => 'all']);
            } else {
                dd('gagal');
                // Gagal menyimpan data
                Alert::error('Gagal', 'Data gagal disimpan');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data gagal disimpan');
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    public function checkExist(Request $request)
    {
        $alternativeId = $request->input('alternative_id');
        $userId = $request->input('user_id');

        $exists = AlternativeValue::where('alternative_id', $alternativeId)
        ->where('user_id', $userId)
        ->exists();

        return response()->json(['exists' => $exists]);
    }

    /**
     * Display the specified resource.
     */
    public function show(AlternativeValue $alternativeValue)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(AlternativeValue $alternativeValue)
    {
        if (auth()->user()->role == 'pembimbing' || auth()->user()->role == 'super_admin') {
            $alternative_id = $alternativeValue->alternative_id;
            $alternatives = Alternative::where('id', $alternativeValue->alternative_id)->get(); // Mengambil semua alternatif untuk dropdown
            $community_id = Alternative::where('id', $alternative_id)->first()->community_id;
            $criterias = Criteria::where('community_id', $community_id)->where('id', $alternativeValue->criteria_id)->get();
            $current_user = auth()->user();

            return view('scoring.edit', compact('alternativeValue', 'alternatives', 'criterias', 'current_user'));
        } else {
            Alert::toast('Akses Dilarang!', 'error');
            return redirect()->back();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlternativeValue $alternativeValue)
    {

        try {
            $validator = Validator::make($request->all(), [
                'value' => 'required',
              ]);

              if ($validator->fails()) {
                Alert::error('Gagal', $validator->errors()->first());
                return redirect()->back()->withInput();
              }

              $alternativeValue->update($request->all());

            // Lakukan perhitungan ulang peringkat dan simpan hasilnya
            $penilaian = app(ScoreResultController::class)->calculateRankingAndStore();
            if ($penilaian) {
                // Berhasil memperbarui data
                Alert::success('Berhasil', 'Data berhasil diperbarui');
                return redirect()->route('scoring.index', ['communityName' => 'all']);
            } else {
                // Gagal menyimpan data
                Alert::error('Gagal', 'Data gagal diperbarui');
                return redirect()->back()->withInput();
            }
        } catch (\Exception $e) {
            // Tangani pengecualian jika terjadi kesalahan
            Alert::error('Gagal', 'Data gagal diperbarui');
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlternativeValue $alternativeValue)
    {
        try {
            // Get the community ID and alternative ID related to this record
            $communityId = $alternativeValue->alternative->community_id;
            $alternativeId = $alternativeValue->alternative_id;

            // Delete all AlternativeValue records that match the same community and alternative
            AlternativeValue::where('alternative_id', $alternativeId)
                            ->whereHas('alternative', function ($query) use ($communityId) {
                                $query->where('community_id', $communityId);
                            })->delete();

            // Optionally, recalculate rankings if needed
            $penilaian = app(ScoreResultController::class)->calculateRankingAndStore();
            if ($penilaian) {
                Alert::success('Berhasil', 'Data berhasil dihapus');
            } else {
                Alert::error('Gagal', 'Data berhasil dihapus, namun gagal memperbarui peringkat');
            }

            // Redirect to the scoring index page
            return redirect()->route('scoring.index', ['communityName' => 'all']);
        } catch (\Exception $e) {
            Alert::error('Gagal', 'Data gagal dihapus');
            return redirect()->back()->withErrors(['error' => $e->getMessage()]);
        }
    }
}
