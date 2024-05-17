<?php

namespace App\Http\Controllers;

use App\Models\Community;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

class CommunityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $Community = Community::query()->paginate(10);
        $title = 'Delete Community!';
        $text = 'Apakah anda yakin ingin menghapus data ini?';
        confirmDelete($title, $text, 'community.destroy');
        return view('community.index', compact('Community'));
    }

    /**
     * Display a listing of the resource.
     */
    public function getCommunity()
    {
        if ($request->ajax()) {
            $data = Community::latest()->get();
            return DataTables::of($data)
            ->addIndexColumn()
            ->addColumn('action', function($row){
                $actionBtn = '<a href="#" class="edit btn btn-success btn-sm">Edit</a> <a href="#" class="delete btn btn-danger btn-sm">Delete</a>';
                return $actionBtn;
            })
            ->rawColumns(['action'])
            ->make(true);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('community.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required'
        ]);

        try {
            Community::create([
                'name' => $request->name
            ]);
            return redirect()->route('community.index');
        } catch (\Exception $e) {
            return redirect()->back()->withInput()->withErrors(['error' => $e->getMessage()]);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Community $community)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Community $community)
    {
        return view('community.edit', compact('community'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Community $community)
    {
      try {
        $validator = Validator::make($request->all(), [
          'name' => 'required',
        ]);

        if ($validator->fails()) {
          Alert::error('Gagal', $validator->errors()->first());
          return redirect()->back()->withInput();
        }

        $community->update($request->all());

        Alert::success('Berhasil', 'Data berhasil diubah');
        return redirect()->route('community.index');
      } catch (\Throwable $th) {
        Alert::error('Gagal', $th->getMessage());
        return redirect()->back()->withInput();
      }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Community $community)
    {
        try {
        $community->delete();
        Alert::success('Berhasil', 'Data berhasil dihapus');
        return redirect()->route('community.index');
        } catch (\Throwable $th) {
        Alert::error('Gagal', $th->getMessage());
        return redirect()->route('community.index');
        }
    }
}
