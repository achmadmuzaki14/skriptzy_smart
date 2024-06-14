<?php

namespace App\Http\Controllers;

use App\Models\ScoreResult;
use App\Models\Criteria;
use App\Models\Community;
use App\Models\Alternative;
use App\Models\AlternativeValue;
use Illuminate\Http\Request;

class ScoreResultController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
       // Mendapatkan hasil penilaian yang sudah diurutkan berdasarkan rank
        $hasil_penilaian = ScoreResult::orderBy('rank')->with('alternative.community')->get();

        // Kelompokkan hasil penilaian berdasarkan nama komunitas
        $hasil_penilaian_grouped = $hasil_penilaian->groupBy(function ($item) {
            return $item->alternative->community->name;
        });

        // Ambil hanya satu perwakilan dari setiap grup komunitas
        $perwakilan_per_komunitas = [];
        foreach ($hasil_penilaian_grouped as $nama_komunitas => $hasil_komunitas) {
            $perwakilan_per_komunitas[] = $hasil_komunitas->first();
        }
        // dd($perwakilan_per_komunitas);

        return view('result.index', compact('perwakilan_per_komunitas'));

    }

    /**
     * Display a listing of the resource.
     */
    public function calculateUtilityForAll()
    {
        // Mendapatkan semua komunitas
        $communities = Community::all();

        // Inisialisasi array untuk menyimpan nilai utility
        $utilityValues = [];

        foreach ($communities as $community) {
            // Mendapatkan semua kriteria dan priority untuk komunitas saat ini
            $criteria = $community->criteria()->get(['id', 'name', 'priority']);

            // Mendapatkan nilai minimum dan maksimum untuk setiap kriteria pada komunitas saat ini
            $criteriaMinMax = [];
            foreach ($criteria as $criterion) {
                $criterionId = $criterion->id;
                $minValue = AlternativeValue::where('criteria_id', $criterionId)
                    ->whereIn('alternative_id', function ($query) use ($community) {
                        $query->select('id')->from('alternatives')->where('community_id', $community->id);
                    })->min('value');
                $maxValue = AlternativeValue::where('criteria_id', $criterionId)
                    ->whereIn('alternative_id', function ($query) use ($community) {
                        $query->select('id')->from('alternatives')->where('community_id', $community->id);
                    })->max('value');
                $criteriaMinMax[$criterionId] = [
                    'min' => $minValue,
                    'max' => $maxValue,
                ];
            }

            // Mendapatkan semua alternatif untuk komunitas saat ini
            $alternatives = Alternative::where('community_id', $community->id)->get(['id', 'name']);

            // Inisialisasi array untuk menyimpan nilai utility untuk komunitas saat ini
            $utilityValues[$community->name] = [];

            foreach ($alternatives as $alternative) {
                $alternativeId = $alternative->id;
                $alternativeName = $alternative->name;

                // Mendapatkan nilai dari alternative untuk komunitas saat ini
                $alternativeValues = AlternativeValue::where('alternative_id', $alternativeId)
                    ->whereIn('criteria_id', $criteria->pluck('id'))
                    ->pluck('value', 'criteria_id');

                // Inisialisasi nilai utility untuk alternatif saat ini
                $utilityValues[$community->name][$alternativeName] = [];

                foreach ($criteria as $criterion) {
                    $criterionId = $criterion->id;
                    $criterionName = $criterion->name;
                    $criterionWeight = $criterion->priority;
                    $minValue = $criteriaMinMax[$criterionId]['min'];
                    $maxValue = $criteriaMinMax[$criterionId]['max'];

                    // Mendapatkan nilai dari alternative untuk kriteria saat ini
                    $alternativeValue = $alternativeValues[$criterionId] ?? 0; // jika tidak ada nilai, default adalah 0

                    if ($maxValue - $minValue == 0) {
                        // Tetapkan nilai utilitas ke 1 (atau nilai yang sesuai dengan kasus Anda)
                        $utility = 1; // atau nilai yang sesuai dengan kasus Anda
                    } else {
                        // Hitung nilai utility
                        $utility = ($alternativeValue - $minValue) / ($maxValue - $minValue);
                    }

                    $utility = number_format($utility, 4);
                    $utilityValues[$community->name][$alternativeName][$criterionName] = $utility;
                }
            }
        }

        return $utilityValues;
    }

    public function calculateFinalUtilityForAll()
    {
        // Mendapatkan semua nilai utility untuk setiap alternatif
        $utilityValues = $this->calculateUtilityForAll();

        // Mendapatkan bobot kriteria untuk setiap komunitas
        $criteriaWeights = $this->criteriaWeight();

        // Inisialisasi array untuk menyimpan nilai akhir utility untuk setiap alternatif
        $finalUtilityValues = [];

        foreach ($utilityValues as $communityName => $alternatives) {
            // Inisialisasi array untuk menyimpan nilai akhir utility untuk alternatif dalam komunitas saat ini
            $finalUtilityValues[$communityName] = [];

            foreach ($alternatives as $alternativeName => $criteriaUtilities) {
                // Inisialisasi nilai akhir utility untuk alternatif saat ini
                $finalUtility = 0;

                foreach ($criteriaUtilities as $criterionName => $utility) {
                    // Mendapatkan bobot kriteria untuk komunitas saat ini
                    $criterionWeight = $criteriaWeights[$communityName][$criterionName];

                    // Menambahkan nilai utility kriteria yang telah diprioritykan
                    $finalUtility += $criterionWeight * $utility;
                }

                // Simpan nilai akhir utility untuk alternatif saat ini
                $finalUtilityValues[$communityName][$alternativeName] = number_format($finalUtility, 4);
            }
        }

        return $finalUtilityValues;
    }

    public function fraction()
    {
        $communities = Community::all();
        $results = collect();

        foreach ($communities as $community) {
            $criteria = $community->criteria()->get(['name', 'priority']);
            $totalCriteria = $criteria->count();
            $communityFraction = collect();

            $criteria->each(function ($item, $key) use ($totalCriteria, $communityFraction) {
                $num = $key + 1;
                $fraction = 1 / $num / $totalCriteria;
                $communityFraction->push([
                    'criteria' => $item->name,
                    'fraction' => $fraction
                ]);
            });

            $results->push($communityFraction);
        }

        return $results;
    }

    public function criteriaWeight()
    {
        $communities = Community::all();
        $resultArray = [];

        foreach ($communities as $community) {
            $communityName = $community->name;
            $criteriaWeight = $this->calculateCriteriaWeight($community);
            $resultArray[$communityName] = $criteriaWeight;
        }

        return $resultArray;
    }

    private function calculateCriteriaWeight($community)
    {
        $criteria = $community->criteria()->get(['name', 'priority']);
        $totalCriteria = $criteria->count();
        $communityFraction = collect();

        $criteria->each(function ($item, $key) use ($totalCriteria, $communityFraction) {
            $num = $key + 1;
            $fraction = 1 / $num / $totalCriteria;
            $communityFraction->push([
                'criteria' => $item->name,
                'fraction' => $fraction
            ]);
        });

        $sumArray = [];
        $totalCriteria = $communityFraction->count();

        for ($i = 0; $i < $totalCriteria; $i++) {
            $nestedArray = $communityFraction->toArray();
            for ($j = 0; $j < $i; $j++) {
                $nestedArray[$j]['fraction'] = 0;
            }
            $sum = array_sum(array_column($nestedArray, 'fraction'));
            $sumArray[] = number_format($sum, 4);
        }

        $criteriaWeight = [];
        foreach ($communityFraction as $key => $item) {
            $criteriaWeight[$item['criteria']] = $sumArray[$key];
        }

        return $criteriaWeight;
    }

    /**
     * Display a listing of the resource.
     */
    // Kode Awal
    // public function calculateRankingAndStore()
    // {
    //     // Mendapatkan semua nilai akhir utility untuk setiap alternatif
    //     $finalUtilityValues = $this->calculateFinalUtilityForAll();

    //     // Mendapatkan semua komunitas yang ada
    //     $communities = Community::all();

    //     try {
    //         // Hapus semua data sebelumnya dari tabel scoreresult
    //         ScoreResult::truncate();

    //         foreach ($communities as $community) {
    //             // Mendapatkan nama komunitas
    //             $communityName = $community->name;

    //             // Mendapatkan alternatif yang terkait dengan komunitas ini
    //             $alternativesInCommunity = Alternative::whereHas('community', function ($query) use ($communityName) {
    //                 $query->where('name', $communityName);
    //             })->get();

    //             // Mengurutkan alternatif berdasarkan nilai akhir utility dari yang tertinggi ke terendah
    //             $rankedAlternatives = $this->sortAlternativesByUtility($finalUtilityValues, $alternativesInCommunity);
    //             // dd($rankedAlternatives);
    //             // Menyimpan peringkat dan data lainnya ke dalam tabel scoreresult
    //             $ranking = 1;
    //             foreach ($rankedAlternatives as $alternativeName => $finalUtility) {
    //                 // Mendapatkan id alternatif berdasarkan nama alternatif
    //                 $alternativeId = Alternative::where('name', $alternativeName)->value('id');
    //                 try {
    //                     // Menyimpan data ke dalam tabel scoreresult
    //                     ScoreResult::create([
    //                         'alternative_id' => $alternativeId,
    //                         'hasil_penilaian' => $finalUtility,
    //                         'rank' => $ranking,
    //                     ]);
    //                     // Jika berhasil, lanjutkan ke proses berikutnya
    //                     // Tambahkan kode berikutnya di sini
    //                 } catch (\Exception $e) {
    //                     // Jika terjadi kesalahan, tampilkan pesan kesalahan
    //                 }
    //                 $ranking++; // Tingkatkan peringkat untuk alternatif berikutnya
    //             }
    //         }
    //     } catch (\Exception $e) {
    //         return redirect()->route('alternative.weboender.index')->withErrors(['error' => $e->getMessage()]);
    //     }

    //     return $alternativeId;
    // }

    // public function sortAlternativesByUtility($finalUtilityValues, $alternativesInCommunity)
    // {
    //     $rankedAlternatives = [];

    //     foreach ($alternativesInCommunity as $alternative) {
    //         $alternativeName = $alternative->name;
    //         $communityName = $alternative->community->name;

    //         // Pastikan bahwa nama komunitas ada dalam array finalUtilityValues
    //         if (isset($finalUtilityValues[$communityName])) {
    //             // Ambil nilai akhir utilitas yang sesuai dengan nama komunitas dan nama alternatif
    //             if (isset($finalUtilityValues[$communityName][$alternativeName])) {
    //                 $finalUtility = $finalUtilityValues[$communityName][$alternativeName];

    //                 // Tambahkan nama alternatif dan nilai akhir utilitas ke dalam array rankedAlternatives
    //                 $rankedAlternatives[$alternativeName] = $finalUtility;
    //             } else {
    //                 // Jika tidak ada nilai akhir utilitas yang sesuai untuk alternatif ini di komunitas tertentu
    //                 // Tindakan lanjutnya bisa berupa penanganan khusus tergantung pada kebutuhan aplikasi Anda
    //                 Log::warning("Nilai akhir utilitas tidak tersedia untuk alternatif '$alternativeName' di komunitas '$communityName'");
    //             }
    //         } else {
    //             // Jika tidak ada nilai akhir utilitas untuk komunitas tertentu
    //             // Tindakan lanjutnya bisa berupa penanganan khusus tergantung pada kebutuhan aplikasi Anda
    //             Log::warning("Nilai akhir utilitas tidak tersedia untuk komunitas '$communityName'");
    //         }
    //     }

    //     // Mengurutkan alternatif berdasarkan nilai akhir utility dari yang tertinggi ke terendah
    //     arsort($rankedAlternatives);

    //     return $rankedAlternatives;
    // }

    // kode akhir

    // kode baru
    public function calculateRankingAndStore()
    {
        // Mendapatkan semua nilai akhir utility untuk setiap alternatif
        $finalUtilityValues = $this->calculateFinalUtilityForAll();

        // Mendapatkan semua komunitas yang ada
        $communities = Community::all();


        try {
            // Hapus semua data sebelumnya dari tabel scoreresult
            ScoreResult::truncate();

            foreach ($communities as $community) {
                // Mendapatkan nama komunitas
                $communityName = $community->name;

                // Mendapatkan alternatif yang terkait dengan komunitas ini
                $alternativesInCommunity = Alternative::whereHas('community', function ($query) use ($communityName) {
                    $query->where('name', $communityName);
                })->get();

                // Mengurutkan alternatif berdasarkan nilai akhir utility dari yang tertinggi ke terendah
                $rankedAlternatives = $this->sortAlternativesByUtility($finalUtilityValues, $alternativesInCommunity);

                // Menyimpan peringkat dan data lainnya ke dalam tabel scoreresult
                $ranking = 1;
                foreach ($rankedAlternatives as $alternativeName => $finalUtility) {
                    // Mendapatkan id alternatif berdasarkan nama alternatif dan komunitas
                    $alternativeId = Alternative::where('name', $alternativeName)
                                                ->where('community_id', $community->id)
                                                ->value('id');

                    if ($alternativeId) {
                        try {
                            // Menyimpan data ke dalam tabel scoreresult
                            ScoreResult::create([
                                'alternative_id' => $alternativeId,
                                'hasil_penilaian' => $finalUtility,
                                'rank' => $ranking,
                            ]);
                        } catch (\Exception $e) {
                            Log::error('Error storing score result: ' . $e->getMessage());
                        }
                        $ranking++; // Tingkatkan peringkat untuk alternatif berikutnya
                    } else {
                        Log::warning("Alternative ID not found for '$alternativeName' in community '$communityName'");
                    }
                }
            }
        } catch (\Exception $e) {
            return redirect()->route('alternative.weboender.index')->withErrors(['error' => $e->getMessage()]);
        }

        return true;
    }

    public function sortAlternativesByUtility($finalUtilityValues, $alternativesInCommunity)
    {
        $rankedAlternatives = [];

        foreach ($alternativesInCommunity as $alternative) {
            $alternativeName = $alternative->name;
            $communityName = $alternative->community->name;

            // Pastikan bahwa nama komunitas ada dalam array finalUtilityValues
            if (isset($finalUtilityValues[$communityName])) {
                // Ambil nilai akhir utilitas yang sesuai dengan nama komunitas dan nama alternatif
                if (isset($finalUtilityValues[$communityName][$alternativeName])) {
                    $finalUtility = $finalUtilityValues[$communityName][$alternativeName];

                    // Tambahkan nama alternatif dan nilai akhir utilitas ke dalam array rankedAlternatives
                    $rankedAlternatives[$alternativeName] = $finalUtility;
                } else {
                    Log::warning("Nilai akhir utilitas tidak tersedia untuk alternatif '$alternativeName' di komunitas '$communityName'");
                }
            } else {
                Log::warning("Nilai akhir utilitas tidak tersedia untuk komunitas '$communityName'");
            }
        }

        // Mengurutkan alternatif berdasarkan nilai akhir utility dari yang tertinggi ke terendah
        arsort($rankedAlternatives);

        return $rankedAlternatives;
    }

    // akhir kode baru


    /**
     * Display the specified resource.
     */
    // public function show($communityName)
    // {
    //    // Mendapatkan data terbaru dari setiap komunitas
    //     $latestResults = ScoreResult::whereHas('alternative.community', function ($query) use ($communityName) {
    //         $query->where('name', $communityName);
    //     })->latest()->get();

    //     // Kelompokkan hasil berdasarkan alternative_id dan ambil yang terbaru
    //     $groupedResults = $latestResults->groupBy('alternative_id')->map(function ($group) {
    //         return $group->first();
    //     });

    //     $sortedResults = $groupedResults->sortBy('rank');

    //     // dd($groupedResults);
    //     return view('result.show', compact('sortedResults'));
    // }

    public function show($communityName)
    {
        // Mendapatkan semua alternatif yang terkait dengan komunitas yang diberikan
        $alternativesInCommunity = Alternative::whereHas('community', function ($query) use ($communityName) {
            $query->where('name', $communityName);
        })->get();

        // Debugging: Memastikan semua alternatif yang diambil
        // dd($alternativesInCommunity->pluck('id'));

        // Mendapatkan semua ScoreResult yang terkait dengan alternatif dalam komunitas tersebut
        $latestResults = ScoreResult::whereIn('alternative_id', $alternativesInCommunity->pluck('id'))
            ->orderBy('created_at', 'desc')
            ->get();

        // Debugging: Memastikan semua hasil terbaru yang diambil
        // dd($latestResults);

        // Kelompokkan hasil berdasarkan alternative_id dan ambil yang terbaru untuk setiap alternative
        $groupedResults = $latestResults->groupBy('alternative_id')->map(function ($group) {
            return $group->first();
        });

        // Urutkan hasil berdasarkan rank
        $sortedResults = $groupedResults->sortBy('rank');

        return view('result.show', compact('sortedResults', 'communityName'));
    }

    public function showUtility($communityName, $alternativeName)
    {
        // Mendapatkan semua nilai utilitas
        $utilityValues = $this->calculateUtilityForAll();

        // Cek apakah komunitas dan alternatif ada dalam data utilitas
        if (isset($utilityValues[$communityName]) && isset($utilityValues[$communityName][$alternativeName])) {
            // Mendapatkan nilai utilitas untuk komunitas dan alternatif tertentu
            $utilityData = $utilityValues[$communityName][$alternativeName];
        } else {
            // Jika tidak ada data, berikan pesan error atau data default
            $utilityData = [];
        }

        return view('result.detail', compact('communityName', 'alternativeName', 'utilityData'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ScoreResult $scoreResult)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ScoreResult $scoreResult)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ScoreResult $scoreResult)
    {
        //
    }
}
