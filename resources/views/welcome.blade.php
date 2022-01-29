<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }} - Your Podcast From Youtube Videos</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap" rel="stylesheet">

    <!-- Styles -->
    <link rel="stylesheet" href="{{ mix('css/app.css') }}">

    <!-- Scripts -->
    <script src="{{ mix('js/app.js') }}" defer></script>
</head>
<body class="antialiased">

<div class="bg-white">
    <header class="bg-primary-600">
        <nav class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8" aria-label="Top">
            <div class="w-full py-6 flex items-center justify-between border-b border-primary-500 lg:border-none">
                <div class="flex items-center">
                    <a href="/" class="flex items-center">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="h-10 w-10 text-secondary-500">
                            <path fill="currentColor" d="M267.429 488.563C262.286 507.573 242.858 512 224 512c-18.857 0-38.286-4.427-43.428-23.437C172.927 460.134 160 388.898 160 355.75c0-35.156 31.142-43.75 64-43.75s64 8.594 64 43.75c0 32.949-12.871 104.179-20.571 132.813zM156.867 288.554c-18.693-18.308-29.958-44.173-28.784-72.599 2.054-49.724 42.395-89.956 92.124-91.881C274.862 121.958 320 165.807 320 220c0 26.827-11.064 51.116-28.866 68.552-2.675 2.62-2.401 6.986.628 9.187 9.312 6.765 16.46 15.343 21.234 25.363 1.741 3.654 6.497 4.66 9.449 1.891 28.826-27.043 46.553-65.783 45.511-108.565-1.855-76.206-63.595-138.208-139.793-140.369C146.869 73.753 80 139.215 80 220c0 41.361 17.532 78.7 45.55 104.989 2.953 2.771 7.711 1.77 9.453-1.887 4.774-10.021 11.923-18.598 21.235-25.363 3.029-2.2 3.304-6.566.629-9.185zM224 0C100.204 0 0 100.185 0 224c0 89.992 52.602 165.647 125.739 201.408 4.333 2.118 9.267-1.544 8.535-6.31-2.382-15.512-4.342-30.946-5.406-44.339-.146-1.836-1.149-3.486-2.678-4.512-47.4-31.806-78.564-86.016-78.187-147.347.592-96.237 79.29-174.648 175.529-174.899C320.793 47.747 400 126.797 400 224c0 61.932-32.158 116.49-80.65 147.867-.999 14.037-3.069 30.588-5.624 47.23-.732 4.767 4.203 8.429 8.535 6.31C395.227 389.727 448 314.187 448 224 448 100.205 347.815 0 224 0zm0 160c-35.346 0-64 28.654-64 64s28.654 64 64 64 64-28.654 64-64-28.654-64-64-64z" class="text-secondary-500"></path>
                        </svg>
                        <span class="text-3xl text-bold text-secondary-500 ml-2 border-b border-secondary-500">{{ config('app.name') }}</span>
                    </a>
                </div>
                <div class="ml-10 space-x-4">
                    @auth
                        <a href="{{ url('/dashboard') }}"
                           class="inline-block bg-white py-2 px-4 border border-transparent rounded-md text-base font-medium text-primary-600 hover:bg-primary-50">Access</a>
                    @else
                        <a href="{{ route('login') }}"
                           class="inline-block bg-primary-500 py-2 px-4 border border-transparent rounded-md text-base font-medium text-white hover:bg-opacity-75">Log
                            in</a>
                        <a href="{{ route('register') }}"
                           class="inline-block bg-white py-2 px-4 border border-transparent rounded-md text-base font-medium text-primary-600 hover:bg-primary-50">Register</a>
                    @endauth
                </div>
            </div>
        </nav>
    </header>
    <main>
        <!-- Hero section -->
        <div class="pt-8 overflow-hidden sm:pt-12 lg:relative lg:py-48">
            <div
                class="mx-auto max-w-md px-4 sm:max-w-3xl sm:px-6 lg:px-8 lg:max-w-7xl lg:grid lg:grid-cols-2 lg:gap-24">
                <div>
                    <div class="mt-20">
                        <div class="mt-6 sm:max-w-xl">
                            <h1 class="text-4xl font-extrabold text-gray-900 tracking-tight sm:text-5xl">
                                Create A Podcast From Youtube
                            </h1>
                            <p class="mt-6 text-xl text-gray-500">

                            </p>
                        </div>
                        <div class="mt-12 sm:max-w-lg sm:w-full sm:flex">
                            @auth
                                <a href="{{ url('/dashboard') }}"
                                   class="rounded-md border border-transparent px-5 py-3 bg-red-500 text-base font-medium text-white shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:px-10">Access</a>
                            @else
                                <a href="{{ route('register') }}"
                                   class="rounded-md border border-transparent px-5 py-3 bg-red-500 text-base font-medium text-white shadow hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2 sm:px-10">Get
                                    Started</a>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>

            <div class="sm:mx-auto sm:max-w-3xl sm:px-6">
                <div class="py-12 sm:relative sm:mt-12 sm:py-16 lg:absolute lg:inset-y-0 lg:right-0 lg:w-1/2">
                    <div class="relative pl-4 -mr-40 sm:mx-auto sm:max-w-3xl sm:px-0 lg:max-w-none lg:h-full lg:pl-12">
                        <img
                            class="w-full rounded-md shadow-xl ring-1 ring-black ring-opacity-5 lg:h-full lg:w-auto lg:max-w-none"
                            src="{{asset('img/welcome.jpg')}}" alt="mic">
                    </div>
                </div>
            </div>
        </div>
<?php /*
        <!-- This example requires Tailwind CSS v2.0+ -->
        <div x-data="{ price: 'year' }">
            <div class="relative bg-primary-600 py-16 sm:py-32">

                <div class="relative max-w-2xl mx-auto px-4 text-center sm:px-6 lg:max-w-7xl lg:px-8">
                    <h1 class="text-4xl font-extrabold tracking-tight text-white sm:text-6xl">
                        <span class="block lg:inline">Pricing made simple,</span>
                        <span class="block lg:inline">no commitment.</span>
                    </h1>
                    <p class="mt-4 text-xl text-primary-100">
                        For personal or publishing needs, pick what best suits you.
                    </p>
                </div>

                <h2 class="sr-only">Plans</h2>

                <!-- Toggle -->
                <div class="relative mt-12 flex justify-center sm:mt-16">
                    <div class="bg-primary-700 p-0.5 rounded-lg flex">
                        <button type="button"
                                @click="price='month'"
                                :class="{ 'bg-white border-primary-700 shadow-sm text-primary-700 hover:bg-primary-50': price==='month',  'border-transparent text-primary-200 hover:bg-primary-800': price!=='month'}"
                                class="relative py-2 px-6 border rounded-md text-sm font-medium whitespace-nowrap hover:bg-primary-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-primary-700 focus:ring-white focus:z-10">
                            Monthly billing
                        </button>
                        <button type="button"
                                @click="price='year'"
                                :class="{ 'bg-white border-primary-700 shadow-sm text-primary-700 hover:bg-primary-50': price==='year',  'border-transparent text-primary-200 hover:bg-primary-800': price!=='year'}"
                                class="ml-0.5 relative py-2 px-6 border rounded-md text-sm font-medium whitespace-nowrap focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-primary-700 focus:ring-white focus:z-10">
                            Yearly billing
                        </button>
                    </div>
                </div>


                <!-- Cards -->
                @foreach(['month', 'year'] as $pricePeriod)
                <div :class="{'hidden': price !== '{{$pricePeriod}}', 'block': price === '{{$pricePeriod}}' }" class="relative mt-8 max-w-2xl mx-auto px-4 pb-8 sm:mt-12 sm:px-6 lg:max-w-7xl lg:px-8 lg:pb-0">
                    <div class="mt-24 space-y-12 lg:space-y-0 lg:grid lg:grid-cols-3 lg:gap-x-8">
                        @foreach($plans as $plan)
                            <div
                                class="relative p-8 bg-white border border-gray-200 rounded-2xl shadow-sm flex flex-col">
                                <div class="flex-1">
                                    <h3 class="text-xl font-semibold text-gray-900">{{ $plan->name }}</h3>
                                    <p class="mt-4 flex items-baseline text-gray-900">
                                        @if($plan->price->$pricePeriod === 0)
                                            <span
                                                class="text-5xl font-extrabold tracking-tight">
                                                Free
                                            </span>
                                        @else
                                            <span
                                                class="text-5xl font-extrabold tracking-tight">${{ $plan->price->$pricePeriod }}</span>
                                            <span class="ml-1 text-xl font-semibold">/{{ $pricePeriod }}</span>
                                        @endif
                                    </p>
                                    <p class="mt-6 text-gray-500">{{ $plan->description }}</p>

                                    <!-- Feature list -->
                                    <ul role="list" class="mt-6 space-y-6">
                                        @foreach($plan->features as $feature)
                                            <li class="flex">
                                                <!-- Heroicon name: outline/check -->
                                                <svg class="flex-shrink-0 w-6 h-6 text-secondary-500"
                                                     xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                                     stroke="currentColor" aria-hidden="true">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                          stroke-width="2" d="M5 13l4 4L19 7"/>
                                                </svg>
                                                <span class="ml-3 text-gray-500">
                                            {{ $feature }}
                                        </span>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>

                                <a href="#"
                                   class="bg-primary-50 text-primary-700 hover:bg-primary-100 mt-8 block w-full py-3 px-6 border border-transparent rounded-md text-center font-medium">Monthly
                                    billing</a>
                            </div>
                        @endforeach
                    </div>
                </div>
                @endforeach
            </div>
        </div>
*/ ?>
    </main>

    <!-- Footer section -->
    <footer class="mt-24 bg-primary-500 sm:mt-12">
        <div class="mx-auto max-w-md py-12 px-4 overflow-hidden sm:max-w-3xl sm:px-6 lg:max-w-7xl lg:px-8">
            <?php /*
     <nav class="-mx-5 -my-2 flex flex-wrap justify-center" aria-label="Footer">
                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-400 hover:text-gray-300">
                            About
                        </a>
                    </div>

                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-400 hover:text-gray-300">
                            Blog
                        </a>
                    </div>

                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-400 hover:text-gray-300">
                            Jobs
                        </a>
                    </div>

                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-400 hover:text-gray-300">
                            Press
                        </a>
                    </div>

                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-400 hover:text-gray-300">
                            Accessibility
                        </a>
                    </div>

                    <div class="px-5 py-2">
                        <a href="#" class="text-base text-gray-400 hover:text-gray-300">
                            Partners
                        </a>
                    </div>
                </nav>
                <div class="mt-8 flex justify-center space-x-6">
                    <a href="#" class="text-gray-400 hover:text-gray-300">
                        <span class="sr-only">Facebook</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M22 12c0-5.523-4.477-10-10-10S2 6.477 2 12c0 4.991 3.657 9.128 8.438 9.878v-6.987h-2.54V12h2.54V9.797c0-2.506 1.492-3.89 3.777-3.89 1.094 0 2.238.195 2.238.195v2.46h-1.26c-1.243 0-1.63.771-1.63 1.562V12h2.773l-.443 2.89h-2.33v6.988C18.343 21.128 22 16.991 22 12z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>

                    <a href="#" class="text-gray-400 hover:text-gray-300">
                        <span class="sr-only">Instagram</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M12.315 2c2.43 0 2.784.013 3.808.06 1.064.049 1.791.218 2.427.465a4.902 4.902 0 011.772 1.153 4.902 4.902 0 011.153 1.772c.247.636.416 1.363.465 2.427.048 1.067.06 1.407.06 4.123v.08c0 2.643-.012 2.987-.06 4.043-.049 1.064-.218 1.791-.465 2.427a4.902 4.902 0 01-1.153 1.772 4.902 4.902 0 01-1.772 1.153c-.636.247-1.363.416-2.427.465-1.067.048-1.407.06-4.123.06h-.08c-2.643 0-2.987-.012-4.043-.06-1.064-.049-1.791-.218-2.427-.465a4.902 4.902 0 01-1.772-1.153 4.902 4.902 0 01-1.153-1.772c-.247-.636-.416-1.363-.465-2.427-.047-1.024-.06-1.379-.06-3.808v-.63c0-2.43.013-2.784.06-3.808.049-1.064.218-1.791.465-2.427a4.902 4.902 0 011.153-1.772A4.902 4.902 0 015.45 2.525c.636-.247 1.363-.416 2.427-.465C8.901 2.013 9.256 2 11.685 2h.63zm-.081 1.802h-.468c-2.456 0-2.784.011-3.807.058-.975.045-1.504.207-1.857.344-.467.182-.8.398-1.15.748-.35.35-.566.683-.748 1.15-.137.353-.3.882-.344 1.857-.047 1.023-.058 1.351-.058 3.807v.468c0 2.456.011 2.784.058 3.807.045.975.207 1.504.344 1.857.182.466.399.8.748 1.15.35.35.683.566 1.15.748.353.137.882.3 1.857.344 1.054.048 1.37.058 4.041.058h.08c2.597 0 2.917-.01 3.96-.058.976-.045 1.505-.207 1.858-.344.466-.182.8-.398 1.15-.748.35-.35.566-.683.748-1.15.137-.353.3-.882.344-1.857.048-1.055.058-1.37.058-4.041v-.08c0-2.597-.01-2.917-.058-3.96-.045-.976-.207-1.505-.344-1.858a3.097 3.097 0 00-.748-1.15 3.098 3.098 0 00-1.15-.748c-.353-.137-.882-.3-1.857-.344-1.023-.047-1.351-.058-3.807-.058zM12 6.865a5.135 5.135 0 110 10.27 5.135 5.135 0 010-10.27zm0 1.802a3.333 3.333 0 100 6.666 3.333 3.333 0 000-6.666zm5.338-3.205a1.2 1.2 0 110 2.4 1.2 1.2 0 010-2.4z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>

                    <a href="#" class="text-gray-400 hover:text-gray-300">
                        <span class="sr-only">Twitter</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path
                                d="M8.29 20.251c7.547 0 11.675-6.253 11.675-11.675 0-.178 0-.355-.012-.53A8.348 8.348 0 0022 5.92a8.19 8.19 0 01-2.357.646 4.118 4.118 0 001.804-2.27 8.224 8.224 0 01-2.605.996 4.107 4.107 0 00-6.993 3.743 11.65 11.65 0 01-8.457-4.287 4.106 4.106 0 001.27 5.477A4.072 4.072 0 012.8 9.713v.052a4.105 4.105 0 003.292 4.022 4.095 4.095 0 01-1.853.07 4.108 4.108 0 003.834 2.85A8.233 8.233 0 012 18.407a11.616 11.616 0 006.29 1.84"/>
                        </svg>
                    </a>

                    <a href="#" class="text-gray-400 hover:text-gray-300">
                        <span class="sr-only">GitHub</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M12 2C6.477 2 2 6.484 2 12.017c0 4.425 2.865 8.18 6.839 9.504.5.092.682-.217.682-.483 0-.237-.008-.868-.013-1.703-2.782.605-3.369-1.343-3.369-1.343-.454-1.158-1.11-1.466-1.11-1.466-.908-.62.069-.608.069-.608 1.003.07 1.531 1.032 1.531 1.032.892 1.53 2.341 1.088 2.91.832.092-.647.35-1.088.636-1.338-2.22-.253-4.555-1.113-4.555-4.951 0-1.093.39-1.988 1.029-2.688-.103-.253-.446-1.272.098-2.65 0 0 .84-.27 2.75 1.026A9.564 9.564 0 0112 6.844c.85.004 1.705.115 2.504.337 1.909-1.296 2.747-1.027 2.747-1.027.546 1.379.202 2.398.1 2.651.64.7 1.028 1.595 1.028 2.688 0 3.848-2.339 4.695-4.566 4.943.359.309.678.92.678 1.855 0 1.338-.012 2.419-.012 2.747 0 .268.18.58.688.482A10.019 10.019 0 0022 12.017C22 6.484 17.522 2 12 2z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>

                    <a href="#" class="text-gray-400 hover:text-gray-300">
                        <span class="sr-only">Dribbble</span>
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                            <path fill-rule="evenodd"
                                  d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10c5.51 0 10-4.48 10-10S17.51 2 12 2zm6.605 4.61a8.502 8.502 0 011.93 5.314c-.281-.054-3.101-.629-5.943-.271-.065-.141-.12-.293-.184-.445a25.416 25.416 0 00-.564-1.236c3.145-1.28 4.577-3.124 4.761-3.362zM12 3.475c2.17 0 4.154.813 5.662 2.148-.152.216-1.443 1.941-4.48 3.08-1.399-2.57-2.95-4.675-3.189-5A8.687 8.687 0 0112 3.475zm-3.633.803a53.896 53.896 0 013.167 4.935c-3.992 1.063-7.517 1.04-7.896 1.04a8.581 8.581 0 014.729-5.975zM3.453 12.01v-.26c.37.01 4.512.065 8.775-1.215.25.477.477.965.694 1.453-.109.033-.228.065-.336.098-4.404 1.42-6.747 5.303-6.942 5.629a8.522 8.522 0 01-2.19-5.705zM12 20.547a8.482 8.482 0 01-5.239-1.8c.152-.315 1.888-3.656 6.703-5.337.022-.01.033-.01.054-.022a35.318 35.318 0 011.823 6.475 8.4 8.4 0 01-3.341.684zm4.761-1.465c-.086-.52-.542-3.015-1.659-6.084 2.679-.423 5.022.271 5.314.369a8.468 8.468 0 01-3.655 5.715z"
                                  clip-rule="evenodd"/>
                        </svg>
                    </a>
                </div>
     */ ?>
            <p class="mt-8 text-center text-base text-gray-400">
                &copy; {{ date('Y') }} {{ config('app.name') }}
            </p>
        </div>
    </footer>
</div>
</body>
</html>
