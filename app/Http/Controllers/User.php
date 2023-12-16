<?php

namespace App\Http\Controllers;

use App\Models\User as ModelsUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class User extends Controller
{
    public function showProfile()
    {
        $userId = Auth::user()->id;
        $user = ModelsUser::find($userId);
          
        return view('logged.pages.profile.index', compact('user'));
    }

    public function update(Request $request)
    {

        $userid= Auth::user()->id;
        $validData = $request->validate([
            'ktp_image' => 'required|image|mimes:jpeg,png'
        ]);

        if(!$validData) {
            return redirect('/profile')->with('updateSuccess', false);
        }


        $userData = ModelsUser::find($userid);

        if($userData->ktp_image !== null) {
            Storage::disk('public')->delete($userData->ktp_image);
        }

        if($request->hasFile('ktp_image')) {
            $validData['ktp_image'] = $request->file('ktp_image')->store('ktp_user', 'public');
        }

        
        ModelsUser::where('id', $userid)->update($validData);
        return redirect('/profile')->with('updateSuccess', true);
    }
}
