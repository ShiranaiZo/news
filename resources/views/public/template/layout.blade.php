<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title')</title>

    <link rel="stylesheet" href="{{asset('assets/css/main/app.css')}}">

    <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.svg')}}" type="image/x-icon">
    <link rel="shortcut icon" href="{{asset('assets/images/logo/favicon.png')}}" type="image/png">

    <link rel="stylesheet" href="{{ asset('assets/css/pages/fontawesome.css') }}">

    @yield('css')
</head>

<body>
    <div class="theme-toggle d-flex gap-2 align-items-center mt-2 d-none">
        <div class="form-check form-switch fs-6">
            <input class="form-check-input d-none me-0" type="checkbox" id="toggle-dark" >
            <label class="form-check-label" ></label>
        </div>
    </div>
    <div id="app">
        <div id="main" class="layout-horizontal">
            <header class="mb-5">
                <div class="header-top">
                    <div class="container">
                        <a href="" class="mx-auto"><img src="{{asset('assets/images/logo/logo.png')}}" alt="Logo" style="width: 75px"></a>
                    </div>
                </div>
            </header>

            <div class="content-wrapper container">
                @yield('content')
            </div>
        </div>
    </div>

    <script src="{{asset('assets/js/bootstrap.js')}}"></script>
    <script src="{{asset('assets/js/app.js')}}"></script>

    <script src="{{asset('assets/extensions/jquery/jquery.min.js')}}"></script>

    <script>
        function cutSentences(text, maxRow = 2) {
            // Membagi teks menjadi array kalimat
            var sentences = text.split("</p>");

            // Mengambil potongan sesuai dengan jumlah maksimum baris yang diinginkan
            var truncated = sentences.slice(0, maxRow - 1);

            // Menggabungkan kembali potongan menjadi satu string dengan baris baru di antara potongan
            var result = truncated.join("\n");

            return result;
        }
    </script>

    @yield('js')

</body>

</html>
