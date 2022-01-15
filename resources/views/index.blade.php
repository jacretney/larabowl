@extends('layouts.app')

@section('content')
    <div id="app">
        <div class="min-h-full">
            <nav class="bg-gray-800">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center justify-between h-16">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <img class="h-8 w-8" src="https://tailwindui.com/img/logos/workflow-mark-indigo-500.svg" alt="Workflow">
                            </div>
                            <div class="hidden md:block">
                                <div class="ml-10 flex items-baseline space-x-4">
                                    <router-link
                                        class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page"
                                        to="/"
                                    >
                                        Home
                                    </router-link>
                                    <router-link
                                        class="bg-gray-900 text-white px-3 py-2 rounded-md text-sm font-medium" aria-current="page"
                                        to="/about"
                                    >
                                        About
                                    </router-link>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </nav>

            <router-view></router-view>
        </div>
    </div>
@endsection
