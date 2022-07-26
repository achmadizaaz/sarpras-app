<?php

namespace App\Http\Controllers;

use App\Models\Building;
use Illuminate\Http\Request;

class BuildingController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $building = Building::all();
        $lastBuilding = Building::orderBy('id', 'desc')->first();

        if (empty($lastBuilding)) {
            $lastCode = 'GD-001';
        } else {
            $lastIncreament = substr($lastBuilding->code, -3);
            $lastCode = 'GD-' . str_pad($lastIncreament + 1, 3, 0, STR_PAD_LEFT);
        }

        return view('backend.building.index', compact('lastCode', 'building'));
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Building::create([
            "code" => $request->code,
            "name" => $request->name,
            "status" => $request->status
        ]);

        return redirect()->route('building.index')->with("success", " $request->name berhasil ditambahkan.");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($slug)
    {
        $building = Building::where('slug', $slug)->first();
        
        return view('backend.building.edit', compact('building'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $slug)
    {
    
      $post = Building::where('slug', $slug)->first();
      $post->slug = null;
      $post->update([
        'name' => $request->name,
        'status' => $request->status,
       ]);

       return redirect()->route('building.index')->with('success', 'Data Berhasil di Update');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Building::where('id', $id)->delete();

        return redirect()->route('building.index')->with('success', 'Data Hapus');
    }
}
