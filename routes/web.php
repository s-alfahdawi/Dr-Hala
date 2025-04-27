<?php

use Illuminate\Support\Facades\Route;

use App\Models\Followup;
Route::get('/', function () {
    return view('welcome');
});

// routes/web.php
Route::get('/api/calendar-followups', function () {
    return Followup::with('patient') // تحميل العلاقة لتفادي N+1
        ->whereNotNull('followup_date')
        ->get()
        ->map(fn($f) => [
            'title' => "{$f->patient?->name} - {$f->type}", // اسم المريضة + نوع المتابعة
            'start' => $f->followup_date->toDateString(),
            'id'    => $f->id,
        ]);
});

Route::post('/followups/{id}/mark-done', function ($id) {
    $f = Followup::findOrFail($id);
    $f->completed = true;
    $f->save();
    return back();
})->name('followup.mark.done');

Route::get('/send-followup/{followup}', function (\App\Models\Followup $followup) {
    $firstName = explode(' ', $followup->patient->name)[0] ?? 'عزيزتي';
    $message = $followup->followupTemplate->message ?? 'نتابعك بعد العملية ❤️';
    $baseMessage = "هلا حبيبتنا {$firstName}،\n{$message}";
    $phone = ltrim($followup->patient->phone, '0');
    $wa = 'https://wa.me/964' . $phone . '?text=' . urlencode($baseMessage);

    $followup->update(['completed' => true]);

    return redirect()->away($wa);
})->name('followups.send');