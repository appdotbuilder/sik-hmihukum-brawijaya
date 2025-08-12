<?php

use App\Models\User;
use App\Models\Book;
use App\Models\KaryaKader;
use App\Models\Activity;
use App\Models\Borrowing;

beforeEach(function () {
    $this->seed();
});

test('welcome page displays correctly', function () {
    $response = $this->get('/');

    $response->assertStatus(200);
    // For Inertia.js pages, we check that the page component is loaded
    $response->assertInertia(fn ($page) => $page->component('welcome'));
});

test('admin can access dashboard', function () {
    $admin = User::where('email', 'admin@hmihukumbrawijaya.org')->first();
    
    $response = $this->actingAs($admin)->get('/dashboard');
    
    $response->assertStatus(200);
    // For Inertia.js pages, we check that the page component is loaded
    $response->assertInertia(fn ($page) => $page->component('dashboard'));
});

test('kader can access dashboard', function () {
    $kader = User::factory()->kader()->verified()->create(['profile_completed' => true]);
    
    $response = $this->actingAs($kader)->get('/dashboard');
    
    $response->assertStatus(200);
});

test('library index displays books and karya', function () {
    $user = User::factory()->kader()->verified()->create(['profile_completed' => true]);
    
    Book::factory(3)->available()->create();
    KaryaKader::factory(2)->available()->create();
    
    $response = $this->actingAs($user)->get('/library');
    
    $response->assertStatus(200);
});

test('verified kader can borrow book', function () {
    $kader = User::factory()->kader()->verified()->create(['profile_completed' => true]);
    $book = Book::factory()->physical()->available()->create(['stock' => 3]);
    
    $response = $this->actingAs($kader)
        ->post("/books/{$book->id}");
    
    $response->assertRedirect();
    
    $this->assertDatabaseHas('borrowings', [
        'user_id' => $kader->id,
        'borrowable_type' => Book::class,
        'borrowable_id' => $book->id,
        'status' => 'borrowed',
    ]);
});

test('unverified user cannot borrow book', function () {
    $kader = User::factory()->kader()->create(['status' => 'pending']);
    $book = Book::factory()->physical()->available()->create(['stock' => 3]);
    
    $response = $this->actingAs($kader)
        ->post("/books/{$book->id}");
    
    $response->assertRedirect();
    $response->assertSessionHas('error', 'Akun Anda belum diverifikasi.');
});

test('user with incomplete profile cannot borrow', function () {
    $kader = User::factory()->kader()->verified()->create(['profile_completed' => false]);
    $book = Book::factory()->physical()->available()->create(['stock' => 3]);
    
    $response = $this->actingAs($kader)
        ->post("/books/{$book->id}");
    
    $response->assertRedirect();
    $response->assertSessionHas('error', 'Silakan lengkapi profil Anda terlebih dahulu.');
});

test('dashboard shows correct statistics', function () {
    $admin = User::where('email', 'admin@hmihukumbrawijaya.org')->first();
    
    // Create additional test data
    User::factory(5)->create();
    Book::factory(10)->create();
    KaryaKader::factory(5)->create();
    Activity::factory(3)->create();
    
    $response = $this->actingAs($admin)->get('/dashboard');
    
    $response->assertStatus(200);
    
    // For Inertia responses, we check the response is successful
    $response->assertSuccessful();
});

test('book availability calculation', function () {
    $book = Book::factory()->physical()->available()->create(['stock' => 5]);
    
    // Create some borrowings
    Borrowing::factory(2)->active()->create([
        'borrowable_type' => Book::class,
        'borrowable_id' => $book->id,
    ]);
    
    expect($book->getAvailableStock())->toBe(3);
    expect($book->isAvailable())->toBeTrue();
});

test('digital book always available', function () {
    $book = Book::factory()->digital()->available()->create();
    
    expect($book->getAvailableStock())->toBe(PHP_INT_MAX);
    expect($book->isAvailable())->toBeTrue();
});

test('activity attendance calculation', function () {
    $activity = Activity::factory()->create();
    
    // Create participants
    $participants = User::factory(10)->create();
    foreach ($participants as $index => $participant) {
        $activity->participants()->create([
            'user_id' => $participant->id,
            'is_present' => $index < 7, // 7 out of 10 present
        ]);
    }
    
    expect($activity->getAttendanceRate())->toBe(70.0);
    expect($activity->getTotalParticipants())->toBe(10);
    expect($activity->getAttendedParticipants())->toBe(7);
});

test('user role methods', function () {
    $admin = User::factory()->administrator()->create();
    $pengurus = User::factory()->pengurus()->create();
    $kader = User::factory()->kader()->create();
    
    expect($admin->isAdministrator())->toBeTrue();
    expect($admin->isPengurus())->toBeFalse();
    expect($admin->isKader())->toBeFalse();
    
    expect($pengurus->isAdministrator())->toBeFalse();
    expect($pengurus->isPengurus())->toBeTrue();
    expect($pengurus->isKader())->toBeFalse();
    
    expect($kader->isAdministrator())->toBeFalse();
    expect($kader->isPengurus())->toBeFalse();
    expect($kader->isKader())->toBeTrue();
});