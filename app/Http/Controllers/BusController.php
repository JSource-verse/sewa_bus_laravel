<?php

namespace App\Http\Controllers;

use App\Models\Bus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BusController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = Bus::orderBy('created_at', 'desc')->get();
        return view('logged.pages.bus.index', compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg',
            'nama' => 'required|string',
            'jumlah_kursi' => 'required|numeric',
            'tipe_bus' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('bus-images', 'public');
        } else {
            // Handle the case where no file is uploaded
            return redirect('/bus/create')->with('error', 'Please upload a valid image file.');
        }

        Bus::create($validatedData);

        return redirect('/bus/create')->with('success', 'Create Bus Success');

    }

    /**
     * Display the specified resource.
     */
    public function show(Bus $bus, $id)
    {
        $bus = Bus::findOrFail($id);
        return view('logged.pages.bus.edit', compact('bus'));
    }

    /**
     *
     * Show the form for editing the specified resource.
     */
    public function edit(Bus $Bus)
    {

        
        return view('logged.pages.bus.create');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $bus = Bus::where('id', $id)->first();

        $oldPhotoPath = $bus->photo;

        $validateData = $request->validate([
            'photo' => 'required|image|mimes:jpeg,png,jpg',
            'nama' => 'required|string',
            'jumlah_kursi' => 'required|numeric',
            'tipe_bus' => 'required|string',
            'harga' => 'required|numeric',
        ]);

        if ($request->hasFile('photo')) {
            if ($oldPhotoPath) {
                Storage::disk('public')->delete($oldPhotoPath);
            }

           
            $newPhotoPath = $request->file('photo')->store('bus-images', 'public');

            $bus->update(['photo' => $newPhotoPath]);
        }

        $bus->update([
            'nama' => $validateData['nama'],
            'jumlah_kursi' => $validateData['jumlah_kursi'],
            'tipe_bus' => $validateData['tipe_bus'],
            'harga' => $validateData['harga'],
        ]);


        return redirect('/bus')->with('successEdit', 'Sukses Edit Bus');


    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bus $Bus, $id)
    {

        $bus = Bus::where('id', $id)->first();
    

        if($bus->photo) {
            Storage::delete('public/storage'. $bus->photo);
        }
        

        Bus::where('id', $id)->delete();
        return redirect('/bus/')->with('successDelete', 'sukses');
    }
}
