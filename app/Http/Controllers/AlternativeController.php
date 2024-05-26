<?php

namespace App\Http\Controllers;

use App\Models\Alternative;
use App\Models\Community;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class AlternativeController extends Controller
{
    public function index()
    {
        // if ($communityName == 'all') {
        //     if (auth()->user()->role == 'super_admin') {
        //         $alternatives = Alternative::query()->get();
        //         return view('alternative.weboender.index', compact('alternatives'));
        //     } else {
        //         Alert::toast('Akses Dilarang!', 'error');
        //         return redirect()->back();
        //     }
        // } else {
        //     // Dapatkan ID komunitas berdasarkan nama dari URL
        //     $communityId = Community::where('name', $communityName)->value('id');

        //     // Dapatkan alternatif nilai yang terkait dengan ID komunitas
        //     $alternatives = Alternative::whereHas('community', function ($query) use ($communityId) {
        //         $query->where('communities.id', $communityId);
        //     })->with('community')->latest()->get();

        //     return view('alternative.weboender.index', compact('alternatives'));
        // }
            $alternatives = Alternative::query()->get()->load('community')->groupBy('community_id');
            $title = 'Delete Alternative!';
            $text = 'Apakah anda yakin ingin menghapus data ini?';
            confirmDelete($title, $text, 'alternative.destroy');
            return view('alternative.weboender.index', compact('alternatives'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->role == 'pembimbing' || auth()->user()->role == 'super_admin') {
            $communities = Community::latest()->get();
            return view('alternative.weboender.create', compact('communities'));
        }else{
            Alert::toast('Akses Dilarang!', 'error');
            return redirect()->back();
        }

    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        try {
            Alternative::create([
                'name' => $request->name,
                'community_id' => $request->community_id
            ]);
            return redirect()->route('alternative.weboender.index');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }

    }

    public function getCommunityIdByAlternative(Request $request)
    {
        $alternativeId = $request->input('alternative_id');
        $communityId = Alternative::where('id', $alternativeId)->first()->community_id;
        return response()->json([
        'community_id' => $communityId
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alternative $alternative)
    {
        if (auth()->user()->role == 'pembimbing' || auth()->user()->role == 'super_admin') {
            $communities = Community::latest()->get();
            return view('alternative.weboender.edit', compact('alternative', 'communities'));
        } else {
            Alert::toast('Akses Dilarang!', 'error');
            return redirect()->back();
        }
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alternative $alternative)
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

        $alternative->update($request->all());

        Alert::success('Berhasil', 'Data berhasil diubah');
        return redirect()->route('alternative.weboender.index');
      } catch (\Throwable $th) {
        Alert::error('Gagal', $th->getMessage());
        return redirect()->back()->withInput();
      }
    }


    public function destroy(Alternative $alternative)
    {
        try {
        $alternative->delete();
        Alert::success('Berhasil', 'Data berhasil dihapus');
        return redirect()->route('alternative.weboender.index');
        } catch (\Throwable $th) {
        Alert::error('Gagal', $th->getMessage());
        return redirect()->route('alternative.weboender.index');
        }
    }
}


