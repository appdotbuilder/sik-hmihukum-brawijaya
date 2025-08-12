<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\KaryaKader;
use Illuminate\Http\Request;
use Inertia\Inertia;

class LibraryController extends Controller
{
    /**
     * Display the library index.
     */
    public function index(Request $request)
    {
        $books = Book::query()
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%")
                      ->orWhere('author', 'like', "%{$search}%");
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->available()
            ->paginate(12);

        $karyaKaders = KaryaKader::query()
            ->with('user:id,name')
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($request->type, function ($query, $type) {
                $query->where('type', $type);
            })
            ->when($request->category, function ($query, $category) {
                $query->where('category', $category);
            })
            ->available()
            ->paginate(12);

        return Inertia::render('library/index', [
            'books' => $books,
            'karyaKaders' => $karyaKaders,
            'filters' => $request->only(['search', 'type', 'category']),
        ]);
    }
}