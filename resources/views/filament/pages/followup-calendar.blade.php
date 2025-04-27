<x-filament::page>
    <h2 class="text-lg font-bold text-primary-700 mb-4">تقويم المتابعات</h2>

    {{-- كود تحميل FullCalendar --}}
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>

    {{-- منطقة عرض التقويم --}}
    <div id="calendar"></div>

    @if (app()->environment('production'))
    <script src="{{ asset('build/assets/app-eMHK6VFw.js') }}"></script>
    <link rel="stylesheet" href="{{ asset('build/assets/app-BgIs6n_x.css') }}">
@else
    @vite(['resources/js/calendar.js'])
@endif
</x-filament::page>