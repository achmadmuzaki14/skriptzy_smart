<?php

namespace App\Http\Controllers;

use App\Models\Criteria;
use App\Models\Community;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class CriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // if ($communityName == 'all') {
        //     if (auth()->user()->role == 'super_admin') {
        //         $Criteria = Criteria::latest()->get()->load('community');
        //         return view('criteria.weboender.index', compact('Criteria'));
        //     } else {
        //         Alert::toast('Akses Dilarang!', 'error');
        //         return redirect()->back();
        //     }
        // } else {
        //     // Dapatkan ID komunitas berdasarkan nama dari URL
        //     $communityId = Community::where('name', $communityName)->value('id');

        //     // Dapatkan alternatif nilai yang terkait dengan ID komunitas
        //     $Criteria = Criteria::whereHas('community', function ($query) use ($communityId) {
        //         $query->where('communities.id', $communityId);
        //     })->with('community')->latest()->get();

        //     return view('criteria.weboender.index', compact('Criteria'));
        // }
        $Criteria = Criteria::latest()->get()->load('community');
        $title = 'Delete Criteria!';
        $text = 'Apakah anda yakin ingin menghapus data ini?';
        confirmDelete($title, $text, 'criteria.destroy');
        return view('criteria.weboender.index', compact('Criteria'));

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $communities = Community::latest()->get();
        return view('criteria.weboender.create', compact('communities'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'priority' => 'required',
            'community_id' => 'required'
        ]);

        try {
            Criteria::create([
                'name' => $request->name,
                'priority' => $request->priority,
                'community_id' => $request->community_id
            ]);
            return redirect()->route('criteria.weboender.index');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }

    }

    /**
     * Display the specified resource.
     */
    public function show(Criteria $criteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Criteria $criteria)
    {
        if (auth()->user()->role == 'pembimbing' || auth()->user()->role == 'super_admin') {
            $communities = Community::latest()->get();
            return view('criteria.weboender.edit', compact('criteria', 'communities'));
        } else {
            Alert::toast('Akses Dilarang!', 'error');
            return redirect()->back();
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Criteria $criteria)
    {
      try {
        $validator = Validator::make($request->all(), [
          'name' => 'required',
          'community_id' => 'required',
        ]);

        if ($validator->fails()) {
          Alert::error('Gagal', $validator->errors()->first());
          return redirect()->back()->withInput();
        }

        $criteria->update($request->all());

        Alert::success('Berhasil', 'Data berhasil diubah');
        return redirect()->route('criteria.weboender.index');
      } catch (\Throwable $th) {
        Alert::error('Gagal', $th->getMessage());
        return redirect()->back()->withInput();
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Criteria $criteria)
    {
        try {
        $criteria->delete();
        Alert::success('Berhasil', 'Data berhasil dihapus');
        return redirect()->route('criteria.weboender.index');
        } catch (\Throwable $th) {
        Alert::error('Gagal', $th->getMessage());
        return redirect()->route('criteria.weboender.index');
        }
    }
}
