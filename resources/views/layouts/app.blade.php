<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <link href="https://fonts.googleapis.com/css2?family=Noto+Kufi+Arabic&display=swap" rel="stylesheet">
<style>
    body, html, * {
        font-family: 'Noto Kufi Arabic', sans-serif !important;
    }
</style>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'لوحة التحكم' }}</title>
</head>
<body>

    @include('layouts.header')

    <main class="content">
       
        @yield('content')
    </main>

    @include('layouts.footer')

</body>
</html>