<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class BookController extends Controller
{
    /**
     * Display the specified resource.
     */
    public function show(Book $book)
    {
        return Inertia::render('library/book', [
            'book' => $book,
            'canBorrow' => $book->isAvailable(),
            'availableStock' => $book->getAvailableStock(),
        ]);
    }

    /**
     * Store a borrowing for the book.
     */
    public function store(Request $request, Book $book)
    {
        $user = $request->user();
        
        if (!$user->isVerified()) {
            return back()->with('error', 'Akun Anda belum diverifikasi.');
        }

        if (!$user->profile_completed) {
            return back()->with('error', 'Silakan lengkapi profil Anda terlebih dahulu.');
        }

        if (!$book->isAvailable()) {
            return back()->with('error', 'Buku tidak tersedia untuk dipinjam.');
        }

        // Check if user already borrowed this book
        $existingBorrowing = Borrowing::where('user_id', $user->id)
            ->where('borrowable_type', Book::class)
            ->where('borrowable_id', $book->id)
            ->where('status', 'borrowed')
            ->exists();

        if ($existingBorrowing) {
            return back()->with('error', 'Anda sudah meminjam buku ini.');
        }

        Borrowing::create([
            'user_id' => $user->id,
            'borrowable_type' => Book::class,
            'borrowable_id' => $book->id,
            'borrowed_at' => now(),
            'due_date' => now()->addDays(14), // 2 weeks borrowing period
            'status' => 'borrowed',
        ]);

        return back()->with('success', 'Buku berhasil dipinjam.');
    }
}