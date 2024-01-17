<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use App\Http\Requests\StoreTransactionRequest;
use App\Http\Requests\UpdateTransactionRequest;
use App\Models\Bus;
use App\Models\User;
use App\Models\Website;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request, $busId)
    {

        $userId = Auth::user()->id;
        $bus = Bus::find($busId);
        $user = User::find($userId);
        $website_info = Website::find(1);


        if($user->ktp_image === null || $user->no_hp === null) {
            return redirect('/profile')->with('error', 'Silahkan Lengkapi KTP Sebelum Melakukan Pemesanan');
        }

        return view('logged.pages.booking.index', compact('bus', 'user', 'website_info'));
    }


    public function CheckBusSchedule(Request $request)
    {

        $isAvailable = Transaction::where('bus_id', $request->bus_id)
            ->where('status', '!=', ['permintaan batal disetujui', 'selesai'])
            ->where(function ($query) use ($request) {
                $query->whereBetween('tanggal_checkin', [$request->checkin, $request->checkout])
                    ->orWhereBetween('tanggal_checkout', [$request->checkin, $request->checkout]);
            })->get();


        $bus = Bus::find($request->bus_id);

        $harga = $bus->harga * $request->jumlah_hari;




        $busAvailable = $isAvailable->isEmpty();

        return redirect()->back()->with('busAvailable', $busAvailable)->with('harga', $harga)->with('tanggal_checkin', $request->checkin)->with('tanggal_checkout', $request->checkout)->withInput([
            'checkin' => $request->checkin,
            'checkout' => $request->checkout,
            'jumlah_hari' => $request->jumlah_hari
        ]);
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
    public function store(StoreTransactionRequest $request)
    {

        $validData = $request->validate([
            'bukti_pembayaran' => 'required|image|mimes:jpeg,png',
            'bus_id' => 'required|exists:buses,id',
            'tanggal_checkin' => 'required|date',
            'tanggal_checkout' => 'required|date|after:checkin',
            'durasi_sewa' => 'required|integer|min:1',
            'tujuan' => 'required|string',
            'penjemputan' => 'required|string',
            'keterangan' => 'required|string',
            'total' => 'required|numeric|min:0',
        ]);

        if($request->hasFile('bukti_pembayaran')) {
            $validData['bukti_pembayaran'] = $request->file('bukti_pembayaran')->store('bukti_pembayaran', 'public');
        }

        $validData['user_id'] = Auth::user()->id;

        Transaction::create($validData);

        return redirect('/booking/check/history')->with('successCreate', true);
    }

    /**
     * Display the specified resource.
     */
    public function show(Transaction $transaction)
    {

        $website_info = Website::find(1);

        if(Auth::user()->role === 'admin') {
            $data = Transaction::where('status', '!=', 'batal')->where('status', '!=', 'permintaan batal')->orderBy('created_at', 'DESC')->get();
            return view('logged.pages.transaction.index', compact('data', 'website_info'));
        }

        $data = Transaction::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->get();
        return view('logged.pages.booking.list', compact('data', 'website_info'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Transaction $transaction, $id)
    {
        $website_info = Website::find(1);
        $data = Transaction::find($id);
        return view('logged.pages.transaction.edit', compact('data', 'website_info'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {

        $validData = $request->validate([
            'status' => 'required|string'
        ]);

        if($request->status === 'batal') {
            Transaction::where('id', $id)->update([
               'status' => $request->status,
               'is_cancel' => 1
            ]);
            return redirect('/admin/transaksi')->with('successUpdate', true);
        }

        
        
        Transaction::where('id', $id)->update($validData);
        return redirect('/admin/transaksi')->with('successUpdate', true);
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Transaction $transaction, $id)
    {
        $transaction = Transaction::find($id);

        if($transaction) {
            if($transaction->bukti_pembayaran) {
                Storage::disk('public')->delete($transaction->bukti_pembayaran);
            }
        }

        $transaction->delete();

        return redirect('admin/transaksi')->with('successDelete', true);
    }

    public function cancel(Request $request, $id)
    {
        Transaction::where('id', $id)->update([
            'is_cancel' => 1,
            'alasan' => $request->alasan,
            'status' => 'permintaan batal'
        ]);

        return redirect()->back()->with('successCancel', true);
    }

    public function show_cancel()
    {
        $website_info = Website::find(1);
        $data = Transaction::where('is_cancel', 1)->orderBy('created_at', 'desc')->get();

        return view('logged.pages.transaction.cancel', compact('data', 'website_info'));
    }

}
