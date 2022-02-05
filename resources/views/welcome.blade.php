<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - Your Podcast From Youtube Videos</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

</head>
<body class="antialiased bg-primary-50 h-full">
<div class="min-h-full relative flex flex-col">
    <header class="flex-0 py-2 xs:py-6 bg-primary-600">
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
{{--                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512"--}}
{{--                                 class="h-8 sm:h-10 w-auto">--}}
{{--                                <path fill="currentColor"--}}
{{--                                      d="M267.429 488.563C262.286 507.573 242.858 512 224 512c-18.857 0-38.286-4.427-43.428-23.437C172.927 460.134 160 388.898 160 355.75c0-35.156 31.142-43.75 64-43.75s64 8.594 64 43.75c0 32.949-12.871 104.179-20.571 132.813zM156.867 288.554c-18.693-18.308-29.958-44.173-28.784-72.599 2.054-49.724 42.395-89.956 92.124-91.881C274.862 121.958 320 165.807 320 220c0 26.827-11.064 51.116-28.866 68.552-2.675 2.62-2.401 6.986.628 9.187 9.312 6.765 16.46 15.343 21.234 25.363 1.741 3.654 6.497 4.66 9.449 1.891 28.826-27.043 46.553-65.783 45.511-108.565-1.855-76.206-63.595-138.208-139.793-140.369C146.869 73.753 80 139.215 80 220c0 41.361 17.532 78.7 45.55 104.989 2.953 2.771 7.711 1.77 9.453-1.887 4.774-10.021 11.923-18.598 21.235-25.363 3.029-2.2 3.304-6.566.629-9.185zM224 0C100.204 0 0 100.185 0 224c0 89.992 52.602 165.647 125.739 201.408 4.333 2.118 9.267-1.544 8.535-6.31-2.382-15.512-4.342-30.946-5.406-44.339-.146-1.836-1.149-3.486-2.678-4.512-47.4-31.806-78.564-86.016-78.187-147.347.592-96.237 79.29-174.648 175.529-174.899C320.793 47.747 400 126.797 400 224c0 61.932-32.158 116.49-80.65 147.867-.999 14.037-3.069 30.588-5.624 47.23-.732 4.767 4.203 8.429 8.535 6.31C395.227 389.727 448 314.187 448 224 448 100.205 347.815 0 224 0zm0 160c-35.346 0-64 28.654-64 64s28.654 64 64 64 64-28.654 64-64-28.654-64-64-64z"--}}
{{--                                      class="text-secondary-500"></path>--}}
{{--                            </svg>--}}
                            <span class="">{{config('app.name')}}</span>
                        </a>
                    </div>
                </div>
            </nav>
        </div>
    </header>

    <main class="flex-1">
        <div class="my-16 mx-auto max-w-7xl px-4 sm:my-24 md:my-36 lg:my-64">
            <div class="text-left md:text-center">
                <h1 class="text-4xl font-extrabold text-primary-600 tracking-tight sm:text-5xl">
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

        @auth
        @else
            <div class="bg-primary-600">
                <div class="pt-12 sm:pt-16 lg:pt-24">
                    <div class="max-w-7xl mx-auto text-center px-4 sm:px-6 lg:px-8">
                        <div class="max-w-3xl mx-auto space-y-2 lg:max-w-none">
                            <h2 class="text-lg leading-6 font-semibold text-primary-300 uppercase tracking-wider">
                                Pricing
                            </h2>
                            <p class="text-3xl font-extrabold text-white sm:text-4xl lg:text-5xl">
                                The right price for you, whoever you are
                            </p>
                            <p class="text-xl text-primary-300">
                                Lorem ipsum dolor, sit amet consectetur adipisicing elit. Harum sequi unde repudiandae
                                natus.
                            </p>
                        </div>
                    </div>
                </div>
                <div class="mt-8 pb-12 bg-primary-50 sm:mt-12 sm:pb-16 lg:mt-16 lg:pb-24">
                    <div class="relative">
                        <div class="absolute inset-0 h-3/4 bg-primary-600"></div>
                        <div class="relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                            <div
                                class="max-w-md mx-auto space-y-4 lg:max-w-5xl lg:grid lg:grid-cols-2 lg:gap-5 lg:space-y-0">
                                <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                                    <div class="px-6 py-8 bg-white sm:p-10 sm:pb-6">
                                        <div>
                                            <h3 class="inline-flex px-4 py-1 rounded-full text-sm font-semibold tracking-wide uppercase bg-secondary-100 text-secondary-600"
                                                id="tier-personal">
                                                Personal
                                            </h3>
                                        </div>
                                        <div class="mt-4 flex items-baseline text-6xl font-extrabold">
                                            $49
                                            <span class="ml-1 text-2xl font-medium text-primary-500">
                  /mo
                </span>
                                        </div>
                                        <p class="mt-5 text-lg text-primary-500">
                                            Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                        </p>
                                    </div>
                                    <div
                                        class="flex-1 flex flex-col justify-between px-6 pt-6 pb-8 bg-primary-50 space-y-6 sm:p-10 sm:pt-6">
                                        <ul role="list" class="space-y-4">
                                            <li class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <!-- Heroicon name: outline/check -->
                                                    <svg class="h-6 w-6 text-green-500"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <p class="ml-3 text-base text-primary-700">
                                                    Pariatur quod similique
                                                </p>
                                            </li>

                                            <li class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <!-- Heroicon name: outline/check -->
                                                    <svg class="h-6 w-6 text-green-500"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <p class="ml-3 text-base text-primary-700">
                                                    Sapiente libero doloribus modi nostrum
                                                </p>
                                            </li>

                                            <li class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <!-- Heroicon name: outline/check -->
                                                    <svg class="h-6 w-6 text-green-500"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <p class="ml-3 text-base text-primary-700">
                                                    Vel ipsa esse repudiandae excepturi
                                                </p>
                                            </li>

                                            <li class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <!-- Heroicon name: outline/check -->
                                                    <svg class="h-6 w-6 text-green-500"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <p class="ml-3 text-base text-primary-700">
                                                    Itaque cupiditate adipisci quibusdam
                                                </p>
                                            </li>
                                        </ul>
                                        <div class="rounded-md shadow">
                                            <a href="#"
                                               class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700"
                                               aria-describedby="tier-personal">
                                                Get started
                                            </a>
                                        </div>
                                    </div>
                                </div>

                                <div class="flex flex-col rounded-lg shadow-lg overflow-hidden">
                                    <div class="px-6 py-8 bg-white sm:p-10 sm:pb-6">
                                        <div>
                                            <h3 class="inline-flex px-4 py-1 rounded-full text-sm font-semibold tracking-wide uppercase bg-secondary-100 text-secondary-600"
                                                id="tier-personal">
                                                Publisher
                                            </h3>
                                        </div>
                                        <div class="mt-4 flex items-baseline text-6xl font-extrabold">
                                            $79
                                            <span class="ml-1 text-2xl font-medium text-primary-500">
                  /mo
                </span>
                                        </div>
                                        <p class="mt-5 text-lg text-primary-500">
                                            Lorem ipsum dolor sit amet consectetur, adipisicing elit.
                                        </p>
                                    </div>
                                    <div
                                        class="flex-1 flex flex-col justify-between px-6 pt-6 pb-8 bg-primary-50 space-y-6 sm:p-10 sm:pt-6">
                                        <ul role="list" class="space-y-4">
                                            <li class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <!-- Heroicon name: outline/check -->
                                                    <svg class="h-6 w-6 text-green-500"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <p class="ml-3 text-base text-primary-700">
                                                    Pariatur quod similique
                                                </p>
                                            </li>

                                            <li class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <!-- Heroicon name: outline/check -->
                                                    <svg class="h-6 w-6 text-green-500"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <p class="ml-3 text-base text-primary-700">
                                                    Sapiente libero doloribus modi nostrum
                                                </p>
                                            </li>

                                            <li class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <!-- Heroicon name: outline/check -->
                                                    <svg class="h-6 w-6 text-green-500"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <p class="ml-3 text-base text-primary-700">
                                                    Vel ipsa esse repudiandae excepturi
                                                </p>
                                            </li>

                                            <li class="flex items-start">
                                                <div class="flex-shrink-0">
                                                    <!-- Heroicon name: outline/check -->
                                                    <svg class="h-6 w-6 text-green-500"
                                                         xmlns="http://www.w3.org/2000/svg" fill="none"
                                                         viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                              stroke-width="2" d="M5 13l4 4L19 7"/>
                                                    </svg>
                                                </div>
                                                <p class="ml-3 text-base text-primary-700">
                                                    Itaque cupiditate adipisci quibusdam
                                                </p>
                                            </li>
                                        </ul>
                                        <div class="rounded-md shadow">
                                            <a href="#"
                                               class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-white bg-primary-600 hover:bg-primary-700"
                                               aria-describedby="tier-personal">
                                                Get started
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 relative max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 lg:mt-5">
                        <div class="max-w-md mx-auto lg:max-w-5xl">
                            <div class="rounded-lg bg-primary-100 px-6 py-8 sm:p-10 lg:flex lg:items-center">
                                <div class="flex-1">
                                    <div>
                                        <h3 class="inline-flex px-4 py-1 rounded-full text-sm font-semibold tracking-wide uppercase bg-white text-primary-800">
                                            Free
                                        </h3>
                                    </div>
                                    <div class="mt-4 text-lg text-primary-600">
                                        Get limited access to try out {{ config('app.name') }}, get one feed up to an
                                        hour of content.
                                    </div>
                                </div>
                                <div class="mt-6 rounded-md shadow lg:mt-0 lg:ml-10 lg:flex-shrink-0">
                                    <a href="{{ route('register') }}"
                                       class="flex items-center justify-center px-5 py-3 border border-transparent text-base font-medium rounded-md text-primary-900 bg-white hover:bg-primary-50">
                                        Get Started Now
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endauth
    </main>

    <footer class="flex-0 mt-24 bg-primary-600">
        <div class="mx-auto max-w-md py-4 px-4 overflow-hidden sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
            <p class="text-center text-base text-secondary-500">
                &copy; {{ date('Y') }} {{ config('app.name') }}
            </p>
        </div>
    </footer>
</div>
</body>
</html>
