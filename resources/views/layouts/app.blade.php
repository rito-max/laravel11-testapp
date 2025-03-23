<html>
    <head>
        <title>@yield('title')</title>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1.0" />
        <meta name="csrf-token" content="{{ csrf_token() }}">
        @viteReactRefresh
        @vite(['resources/css/app.css', 'resources/js/app.jsx'])
    </head>
    <body class="text-neutral-800">
        @if(auth()->id())
            <div class="mx-auto w-5/6 mt-16 mb-8 text-right">
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button class="rounded-full  bg-red-400  text-white px-5 py-3 text-sm">ログアウト</button>
                </form>
            </div>
        @endif
        @yield('content')
        @yield('scripts')
    </body>
</html>