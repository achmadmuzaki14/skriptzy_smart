<?php

namespace App\Http\Controllers;

use App\Models\AlternativeValue;
use App\Models\Alternative;
use App\Models\Criteria;
use App\Models\Community;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class AlternativeValueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index($communityName)
    {
        if (($communityName == 'all') ) {
            if (auth()->user()->role == 'super_admin') {
                $alternatives = Alternative::latest()->get();
                $alternative_values_data = AlternativeValue::query()->get();
                return view('scoring.index', compact(['alternative_values_data', 'alternatives']));
            } else {
                Alert::toast('Akses Dilarang!', 'error');
                return redirect()->back();
            }
        }else {
            if (auth()->user()->role == 'user') {
                $alternative_values_data = AlternativeValue::query()->get();
                return view('scoring.index', compact('alternative_values_data'));
            }else if(auth()->user()->community->name == $communityName){
                // Dapatkan ID komunitas berdasarkan nama dari URL
                $communityId = Community::where('name', $communityName)->value('id');

                // Dapatkan alternatif nilai yang terkait dengan ID komunitas
                $alternative_values_data = AlternativeValue::whereHas('alternative.community', function ($query) use ($communityId) {
                    $query->where('communities.id', $communityId);
                })->with(['alternative', 'user'])->latest()->get();

                return view('scoring.index', compact('alternative_values_data'));
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
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, AlternativeValue $alternativeValue)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(AlternativeValue $alternativeValue)
    {
        //
    }
}
