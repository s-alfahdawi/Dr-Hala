<x-filament::page>
    <h2 class="text-lg font-bold text-primary-700 mb-4">تقويم المتابعات</h2>

    {{-- كود تحميل FullCalendar --}}
    <link href='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.css' rel='stylesheet' />
    <script src='https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/main.min.js'></script>

    {{-- منطقة عرض التقويم --}}
    <div id="calendar"></div>

    {{-- كود الجافا سكربت عبر Vite --}}
    @vite(['resources/js/calendar.js'])
</x-filament::page>