<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'لوحة التحكم' }}</title>
    <link rel="stylesheet" href="{{ asset('css/style.css') }}">
</head>
<body>

    @include('layouts.header')

    <main class="content">
       
        @yield('content')
    </main>

    @include('layouts.footer')

</body>
</html>