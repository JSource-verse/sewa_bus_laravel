<?php

use App\Http\Controllers\BusController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\User;
use App\Http\Controllers\WebsiteController;
use App\Models\Bus;
use App\Models\Transaction;
use App\Models\User as ModelUser;
use App\Models\Website;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect('/login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {

        $website_info = Website::find(1);

        if(Auth::user()->role === 'user') {
            $buses = Bus::all();
            return view('logged.pages.index', compact('buses', 'website_info'));

        }

        $transactions = Transaction::where('status', 'selesai')->count();
        $pendingTransactions = Transaction::where('status', 'menunggu persetujuan')->count();
        $users = ModelUser::where('role', 'user')->count();
        $cancelTransaction = Transaction::where('status', 'permintaan batal')->count();
        $popularBuses = Transaction::join('buses', 'transactions.bus_id', '=', 'buses.id')
            ->groupBy('transactions.bus_id')
            ->where('status', 'selesai')
            ->select('transactions.bus_id', 'buses.nama as nama_bus', DB::raw('COUNT(*) as total_sewa'))
            ->orderBy('total_sewa', 'desc')
            ->get();

            

        return view('logged.pages.index', compact('transactions', 'pendingTransactions', 'users', 'cancelTransaction', 'popularBuses', 'website_info'));
    })->name('dashboard');

    Route::get('/get-chart-data', function (Request $request) {


        $totalTransactionInMonth = [];
        $totalCancelTransactionInMonth = [];
       
        for ($i=1; $i <= 12; $i++) {
            $totalTransaction = Transaction::where('status', 'selesai')
                ->whereMonth('created_at', $i)
                ->whereYear('created_at', intval($request->tahun))
                ->count();

            $totalTransactionInMonth[] = $totalTransaction;

            $totalCancelTransaction = Transaction::where('status', 'permintaan batal disetujui')
               ->whereMonth('created_at', $i)
               ->whereYear('created_at', intval($request->tahun))
               ->count();

            $totalCancelTransactionInMonth[] = $totalCancelTransaction;
        }
        

        return (object)[
            'totalTransactionInMonth' => $totalTransactionInMonth,
            'totalCancelTransactionInMonth' => $totalCancelTransactionInMonth,
            'year' => intval($request->tahun)
        ];
    })->name('getChartData');
});



Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/profile', [User::class, 'showProfile'])->name('dashboard.profile');
    Route::post('/profile', [User::class, 'update'])->name('dashboard.user.profile.update');
})->name('dashboard');

Route::middleware(['auth:sanctum', 'web'])->group(function () {
    Route::get('/bus', [BusController::class, 'index'])->name('dashboard.bus');
    Route::get('/bus/edit/{id}', [BusController::class, 'show'])->name('dashboard.bus.edit');
    Route::get('/bus/create', [BusController::class, 'edit'])->name('dashboard.bus.create');
    Route::post('/bus/create', [BusController::class, 'store'])->name('dashboard.bus.store');
    Route::delete('/bus/delete/{id}', [BusController::class, 'destroy'])->name('dashboard.bus.delete');
    Route::post('/bus/update/{id}', [BusController::class, 'update'])->name('dashboard.bus.update');

    // transaktion/booking route
    Route::get('/booking/bus/{busid}', [TransactionController::class, 'index'])->name('dashboard.booking.index');
    Route::post('/booking/check-schedule', [TransactionController::class, 'CheckBusSchedule'])->name('dashboard.booking.check');
    Route::post('/booking/create', [TransactionController::class, 'store'])->name('dashboard.booking.create');
    Route::get('/booking/check/history', [TransactionController::class, 'show'])->name('dashboard.booking.history');
    Route::post('/booking/cancel/{id}', [TransactionController::class, 'cancel'])->name('dashboard.booking.cancel');

    // admin
    Route::get('/admin/transaksi', [TransactionController::class, 'show'])->name('dashboard.admin.transaction');
    Route::get('/admin/transaksi/edit/{id}', [TransactionController::class, 'edit'])->name('dashboard.admin.transaction.edit');
    Route::post('/admin/transaksi/update/{id}', [TransactionController::class, 'update'])->name('dashboard.admin.transaction.update');
    Route::post('/admin/transaksi/delete/{id}', [TransactionController::class, 'destroy'])->name('dashboard.admin.transaction.delete');
    Route::get('/admin/transaksi/cancel', [TransactionController::class, 'show_cancel'])->name('dashboard.admin.transaction.cancel');
    Route::get('/pengaturan-website', [WebsiteController::class, 'edit'])->name('dashboard.admin.pengaturan');
    Route::post('/pengaturan-website/update', [WebsiteController::class, 'update'])->name('dashboard.admin.pengaturan.update');

})->name('dashboard');
