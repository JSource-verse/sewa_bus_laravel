<?php

namespace App\Http\Controllers;

use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class WebsiteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Website $website)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Website $website)
    {
        $website_info = Website::find(1);
        return view('logged.pages.website.index', compact('website_info'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Website $website)
    {
        $nomorRekeningArray = explode(',', $request->nomor_rekening);
        $nomorRekeningArray = array_map('trim', $nomorRekeningArray);
        $nomorAdminArray = explode(',', $request->nomor_admin);
        $nomorAdminArray = array_map('trim', $nomorAdminArray);
        $sosialMediaArray = explode(',', $request->sosial_media);
        $sosialMediaArray = array_map('trim', $sosialMediaArray);

        $website = Website::find(1);

        if($request->hasFile('sop')){
            $fileName = $request->file('sop')->getClientOriginalName();
            if($website->sop){
                Storage::disk('public')->delete(($website->sop));
            }

            $newSOPPath =  $request->file('sop')->storeAs('SOP', $fileName, 'public');
            $website->update([
                'sop' => $newSOPPath
            ]);

        }
        

        Website::find(1)->update([
            'nama_perusahaan' => $request->nama_perusahaan,
            'nomor_admin' => $nomorAdminArray,
            'nomor_rekening' => $nomorRekeningArray,
            'sosial_media' => $sosialMediaArray
        ]);

        return back()->with('suksesEdit', true);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Website $website)
    {
        //
    }
}
