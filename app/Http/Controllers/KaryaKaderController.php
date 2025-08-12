<?php

namespace App\Http\Controllers;

use App\Models\KaryaKader;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class KaryaKaderController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(KaryaKader $karyaKader)
    {
        $karyaKader->load('user:id,name');
        
        return Inertia::render('library/karya', [
            'karya' => $karyaKader,
            'canBorrow' => $karyaKader->isAvailable(),
            'availableStock' => $karyaKader->getAvailableStock(),
        ]);
    }

    /**
     * Store a borrowing for the karya kader.
     */
    public function store(Request $request, KaryaKader $karyaKader)
    {
        $user = $request->user();
        
        if (!$user->isVerified()) {
            return back()->with('error', 'Akun Anda belum diverifikasi.');
        }

        if (!$user->profile_completed) {
            return back()->with('error', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        if (!$karyaKader->isAvailable()) {
            return back()->with('error', 'Karya tidak tersedia untuk dipinjam.');
        }

        // Check if user already borrowed this karya
        $existingBorrowing = Borrowing::where('user_id', $user->id)
            ->where('borrowable_type', KaryaKader::class)
            ->where('borrowable_id', $karyaKader->id)
            ->where('status', 'borrowed')
            ->exists();

        if ($existingBorrowing) {
            return back()->with('error', 'Anda sudah meminjam karya ini.');
        }

        Borrowing::create([
            'user_id' => $user->id,
            'borrowable_type' => KaryaKader::class,
            'borrowable_id' => $karyaKader->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14), // 2 weeks borrowing period
            'status' => 'borrowed',
        ]);

        return back()->with('success', 'Karya berhasil dipinjam.');
    }
}