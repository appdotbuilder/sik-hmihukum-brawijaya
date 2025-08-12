<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Book;
use App\Models\KaryaKader;
use App\Models\Activity;
use App\Models\Borrowing;
use Illuminate\Http\Request;
use Inertia\Inertia;

class DashboardController extends Controller
{
    /**
     * Display the dashboard.
     */
    public function index(Request $request)
    {
        $user = $request->user();
        
        // Basic statistics
        $stats = [
            'total_users' => User::count(),
            'total_books' => Book::count(),
            'total_digital_books' => Book::digital()->count(),
            'total_physical_books' => Book::physical()->count(),
            'total_karya_kaders' => KaryaKader::count(),
            'total_digital_karya' => KaryaKader::digital()->count(),
            'total_physical_karya' => KaryaKader::physical()->count(),
            'total_activities' => Activity::count(),
            'upcoming_activities' => Activity::where('date', '>=', now()->toDateString())
                                        ->whereIn('status', ['planned', 'ongoing'])
                                        ->count(),
            'active_borrowings' => Borrowing::active()->count(),
            'overdue_borrowings' => Borrowing::overdue()->count(),
        ];

        // Role-specific data
        $roleData = [];
        
        if ($user->isAdministrator() || $user->isPengurus()) {
            $roleData = [
                'pending_users' => User::where('status', 'pending')->count(),
                'recent_activities' => Activity::with('creator')
                    ->latest()
                    ->take(5)
                    ->get(),
                'recent_borrowings' => Borrowing::with(['user', 'borrowable'])
                    ->latest()
                    ->take(5)
                    ->get(),
                'user_distribution' => [
                    'administrator' => User::administrators()->count(),
                    'pengurus' => User::pengurus()->count(),
                    'kader' => User::kader()->count(),
                ],
            ];
        }

        if ($user->isKader()) {
            $roleData = [
                'my_borrowings' => Borrowing::where('user_id', $user->id)
                    ->with('borrowable')
                    ->active()
                    ->get(),
                'my_activities' => $user->activityParticipants()
                    ->with('activity')
                    ->whereHas('activity', function ($query) {
                        $query->where('date', '>=', now()->toDateString())
                              ->whereIn('status', ['planned', 'ongoing']);
                    })
                    ->get(),
            ];
        }

        return Inertia::render('dashboard', [
            'stats' => $stats,
            'roleData' => $roleData,
            'user' => $user,
        ]);
    }
}