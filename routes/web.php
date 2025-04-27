<?php

use Illuminate\Support\Facades\Route;

use App\Models\Followup;
Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/calendar-followups', function () {
    return Followup::with('patient') // تحميل العلاقة لتفادي N+1
        ->whereNotNull('followup_date')
        ->get()
        ->map(function ($f) {
            return [
                'title' => $f->patient?->name . ' - ' . ($f->followupTemplate?->name ?? ''),
                'start' => $f->followup_date->toDateString(),
                'id'    => $f->id,
                'url'   => route('filament.admin.resources.patients.edit', $f->patient?->id), // رابط صفحة تعديل المريضة
                'color' => $f->completed ? '#10B981' : '#EF4444', // أخضر إذا مكتمل، أحمر إذا غير مكتمل
            ];
        });
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