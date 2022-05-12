<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="{{ asset('img/logo.png') }}">

    <title>{{ config('app.name') }} - Your Podcast From Youtube Videos</title>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

</head>
<body class="antialiased bg-primary-50 h-full">
<div class="min-h-full relative flex flex-col">
    <header class="grow-0 py-2 xs:py-6 bg-primary-600">
        <div class="max-w-7xl mx-auto px-4 sm:px-6">
            <nav class="relative flex items-center justify-between sm:h-10 md:justify-center" aria-label="Global">
                <div class="flex items-center flex-1 md:absolute md:inset-y-0 md:left-0">
                    <div class="flex items-center justify-between w-full md:w-auto">
                        <a href="/" class="flex gap-2 items-center text-2xl font-bold leading-5 text-secondary-500">
                            <svg version="1.0" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" class="h-8 sm:h-10 w-auto" preserveAspectRatio="xMidYMid meet">
                                <g transform="translate(0,512) scale(0.1,-0.1)" fill="currentColor" stroke="none">
                                    <path d="M1682 4784 c-56 -28 -90 -63 -125 -128 l-22 -41 0 -2055 0 -2055 23
-43 c56 -104 136 -151 257 -152 114 0 151 13 211 74 87 88 85 66 82 764 l-3
602 -219 -126 c-121 -69 -225 -128 -233 -131 -11 -4 -13 175 -13 1067 0 892 2
1071 13 1067 8 -3 112 -62 233 -131 l219 -126 3 602 c3 697 5 675 -83 764 -59
61 -96 74 -211 74 -66 0 -89 -4 -132 -26z"/>
                                    <path d="M1005 4314 c-68 -18 -122 -57 -166 -121 l-44 -65 0 -1567 0 -1566 30
-50 c41 -69 50 -78 132 -119 98 -49 146 -49 253 0 68 31 84 44 111 86 62 96
58 -13 59 1654 l0 1531 -30 59 c-41 79 -57 97 -121 130 -42 21 -70 28 -129 30
-41 2 -84 1 -95 -2z"/>
                                    <path d="M2510 4074 c-113 -21 -186 -80 -220 -177 -18 -51 -20 -82 -20 -340
l0 -283 193 -111 c105 -62 235 -136 287 -166 l95 -55 3 447 c2 398 0 452 -15
501 -23 73 -88 144 -151 164 -53 17 -135 26 -172 20z"/>
                                    <path d="M3967 4070 c-95 -17 -178 -91 -213 -190 -17 -45 -20 -2573 -4 -2631
19 -66 80 -141 144 -173 50 -26 68 -30 141 -30 73 0 91 4 142 30 63 32 123
105 143 174 14 48 14 2572 0 2620 -6 19 -27 60 -48 90 -61 90 -178 132 -305
110z"/>
                                    <path d="M249 3821 c-68 -21 -130 -75 -165 -144 l-24 -49 0 -1077 c0 -1064 0
-1078 20 -1101 11 -13 20 -27 20 -31 0 -18 65 -81 104 -101 58 -30 190 -37
252 -13 54 21 109 66 131 108 8 17 21 37 29 44 7 7 15 37 19 65 3 29 5 514 3
1078 l-3 1025 -27 50 c-56 106 -138 155 -258 154 -41 0 -87 -4 -101 -8z"/>
                                    <path d="M3202 3576 c-60 -20 -128 -79 -160 -139 l-27 -52 -3 -270 -3 -270
246 -140 c134 -77 245 -142 245 -145 0 -3 -111 -68 -245 -145 l-246 -140 3
-270 c4 -260 5 -272 27 -320 61 -128 220 -187 365 -136 67 23 120 70 155 136
l26 50 0 825 0 825 -27 50 c-30 58 -54 81 -122 120 -58 34 -165 43 -234 21z"/>
                                    <path d="M4689 3581 c-28 -9 -71 -31 -79 -40 -3 -4 -17 -14 -32 -23 -14 -10
-41 -43 -60 -75 l-33 -58 0 -825 0 -825 35 -60 c40 -66 104 -117 173 -136 76
-20 218 3 247 40 3 4 17 14 31 23 15 9 40 42 58 72 l31 56 0 830 0 830 -31 55
c-33 59 -107 117 -171 135 -39 12 -132 12 -169 1z"/>
                                    <path d="M2750 2123 c-52 -30 -182 -105 -288 -166 l-193 -111 3 -306 c3 -291
4 -307 25 -345 30 -57 90 -111 143 -131 58 -21 180 -21 240 1 53 19 113 73
143 130 21 39 22 52 25 425 2 212 2 424 0 471 l-3 87 -95 -55z"/>
                                </g>
                            </svg>
                            <span class="">{{config('app.name')}}</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="flex-auto relative">
        <div class="absolute z-0 top-0 left-0 right-0 bottom-0 bg-cover bg-no-repeat" style="background-image:url('img/background.jpg');">
            <div class="w-full h-full bg-primary-500 bg-opacity-50"></div>
        </div>

        <div class="relative z-10 my-16 mx-auto max-w-7xl px-4 sm:my-24 md:my-36 lg:my-64">
            <div class="text-left md:text-center">
                <h1 class="text-4xl font-extrabold text-white tracking-tight sm:text-5xl">
                    Create a Podcast From <span class="text-red-500">Youtube</span>
                </h1>
                <div class="my-12 xs:my-16 sm:my-20 max-w-xs sm:max-w-md mx-auto sm:flex sm:justify-center">
                    @auth
                        <div class="rounded-md shadow">
                            <a href="{{ url('/dashboard') }}"
                               class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-secondary-600 hover:bg-secondary-700 md:py-4 md:text-lg md:px-10">Access</a>
                        </div>
                    @else
                        <div class="rounded-md shadow">
                            <a href="{{ route('register') }}"
                               class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-white bg-secondary-600 hover:bg-secondary-700 md:py-4 md:text-lg md:px-10">
                                Get Started
                            </a>
                        </div>
                        <div class="mt-3 rounded-md shadow sm:mt-0 sm:ml-3">
                            <a href="{{ route('login') }}"
                               class="w-full flex items-center justify-center px-8 py-3 border border-transparent text-base font-medium rounded-md text-secondary-600 bg-white hover:bg-primary-50 md:py-4 md:text-lg md:px-10">
                                Log in
                            </a>
                        </div>
                    @endauth
                </div>
            </div>
        </div>
    </main>

    <footer class="grow-0 bg-primary-600">
        <div class="mx-auto max-w-md py-4 px-4 overflow-hidden sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
            <p class="text-center text-base text-secondary-500">
                Powered by <a href="https://github.com/mevtho/podyt" title="Github Podyt Repository">podyt</a>
            </p>
        </div>
    </footer>
</div>
</body>
</html>
