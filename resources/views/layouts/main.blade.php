<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ env('APP_NAME') }}</title>

    {{-- google font hind --}}
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Hind+Guntur:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    {{-- css zara --}}
    <link rel="stylesheet" href="/asset/zara/style.css">
</head>

<body>

    <nav>
        <div class="flex">
            <div class="basis-2/12">
                <h3 class="text-white">{{ env('APP_NAME') }}</h3>
            </div>

            <div class="basis-10/12">
                <ul>
                    <a href="/profile">
                        <li>Profile</li>
                    </a>

                    <li class="btn">
                        <button class="bg-danger">Logout</button>
                    </li>

                </ul>
            </div>
        </div>

    </nav>

    <section class="container flex">

        <div class="basis-2/12">
            <aside class="bg-slate-600">

                <div class="profile">
                    <h3 class="text-white mb-0">{{ auth()->user()->name }}</h3>
                </div>

                <hr class="my-5 mx-3">

                <ul>
                    <a href="/">
                        <li>Dashboard</li>
                    </a>

                    <a href="/category">
                        <li>Kategori</li>
                    </a>
                </ul>

            </aside>
        </div>

        <main class="basis-10/12 p-2">
            @yield('main-section')
        </main>

    </section>

</body>

</html>
