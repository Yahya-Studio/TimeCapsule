<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'TimeCapsule') }} - @yield('title', 'كبسولة الزمن')</title>

    <!-- Google Fonts for Arabic Typography -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;500;600;700;800;900&family=Tajawal:wght@400;500;700;800&display=swap" rel="stylesheet">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#07090e] text-slate-100 min-h-screen flex flex-col selection:bg-amber-500 selection:text-black">
    <!-- Ambient Cosmic Background Glows -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 right-10 w-96 h-96 bg-purple-900/20 rounded-full blur-3xl animate-float-slow"></div>
        <div class="absolute top-1/3 -left-20 w-80 h-80 bg-amber-600/10 rounded-full blur-3xl animate-float-slow" style="animation-delay: -3s;"></div>
        <div class="absolute -bottom-20 right-1/4 w-96 h-96 bg-indigo-900/15 rounded-full blur-3xl animate-float-slow" style="animation-delay: -6s;"></div>
    </div>

    <!-- Header / Navbar -->
    <header class="sticky top-0 z-40 glass-panel border-b border-purple-500/15 bg-[#0b0f19]/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <!-- Brand Logo -->
                <div class="flex items-center gap-8">
                    <a href="{{ route('dashboard') }}" class="flex items-center gap-3 group">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber-400 via-purple-600 to-indigo-800 flex items-center justify-center p-0.5 shadow-lg shadow-purple-900/30 group-hover:scale-105 transition-transform">
                            <div class="w-full h-full bg-[#0b0f19] rounded-[10px] flex items-center justify-center">
                                <i data-lucide="hourglass" class="w-5 h-5 text-amber-400"></i>
                            </div>
                        </div>
                        <div>
                            <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-amber-300 via-purple-300 to-white bg-clip-text text-transparent">TimeCapsule</span>
                            <span class="hidden sm:inline-block text-[11px] text-purple-300/60 font-medium mr-1.5">كبسولة الزمن</span>
                        </div>
                    </a>

                    <!-- Desktop Nav Links -->
                    <nav class="hidden md:flex items-center gap-1">
                        <a href="{{ route('dashboard') }}" 
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('dashboard') ? 'bg-purple-600/20 text-amber-300 border border-purple-500/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <span class="flex items-center gap-2">
                                <i data-lucide="layout-dashboard" class="w-4 h-4"></i>
                                لوحة التحكم
                            </span>
                        </a>
                        <a href="{{ route('capsules.index') }}" 
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('capsules.index') && !request()->has('tab') ? 'bg-purple-600/20 text-amber-300 border border-purple-500/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <span class="flex items-center gap-2">
                                <i data-lucide="box" class="w-4 h-4"></i>
                                جميع الكبسولات
                            </span>
                        </a>
                        <a href="{{ route('capsules.closed') }}" 
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('capsules.closed') ? 'bg-purple-600/20 text-amber-300 border border-purple-500/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <span class="flex items-center gap-2">
                                <i data-lucide="lock" class="w-4 h-4 text-purple-400"></i>
                                الكبسولات المغلقة
                            </span>
                        </a>
                        <a href="{{ route('capsules.ready') }}" 
                           class="px-3.5 py-2 rounded-lg text-sm font-medium transition-all {{ request()->routeIs('capsules.ready') ? 'bg-purple-600/20 text-amber-300 border border-purple-500/30' : 'text-slate-300 hover:text-white hover:bg-white/5' }}">
                            <span class="flex items-center gap-2">
                                <i data-lucide="key" class="w-4 h-4 text-emerald-400"></i>
                                المتاحة للفتح
                            </span>
                        </a>
                    </nav>
                </div>

                <!-- Right Actions: Create Button & Profile Menu -->
                <div class="flex items-center gap-3">
                    <a href="{{ route('capsules.create') }}" 
                       class="inline-flex items-center gap-2 px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl font-medium text-sm text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 transition-all shadow-md shadow-amber-500/20 hover:scale-[1.02]">
                        <i data-lucide="plus" class="w-4 h-4 stroke-[2.5]"></i>
                        <span>كبسولة جديدة</span>
                    </a>

                    <!-- User Profile Dropdown -->
                    <div class="relative" x-data="{ open: false }">
                        <button onclick="document.getElementById('user-menu-dropdown').classList.toggle('hidden')" 
                                class="flex items-center gap-2.5 p-1.5 rounded-xl hover:bg-white/5 border border-transparent hover:border-purple-500/20 transition-all">
                            <img src="{{ auth()->user()->avatar_url }}" alt="{{ auth()->user()->name }}" class="w-8 h-8 rounded-lg object-cover ring-2 ring-purple-500/30">
                            <span class="hidden lg:inline text-xs font-medium text-slate-200">{{ auth()->user()->name }}</span>
                            <i data-lucide="chevron-down" class="w-3.5 h-3.5 text-slate-400 hidden lg:inline"></i>
                        </button>

                        <div id="user-menu-dropdown" class="hidden absolute left-0 mt-2 w-56 rounded-2xl glass-panel bg-[#0e1424] border border-purple-500/20 shadow-2xl py-2 z-50">
                            <div class="px-4 py-3 border-b border-purple-500/10">
                                <p class="text-xs text-purple-300 font-medium">مرحباً بك،</p>
                                <p class="text-sm font-semibold text-white truncate">{{ auth()->user()->name }}</p>
                                <p class="text-xs text-slate-400 truncate">{{ auth()->user()->email }}</p>
                            </div>
                            <div class="py-1">
                                <a href="{{ route('profile.edit') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-200 hover:bg-purple-600/20 hover:text-amber-300 transition-colors">
                                    <i data-lucide="user" class="w-4 h-4"></i>
                                    الملف الشخصي
                                </a>
                                <a href="{{ route('settings.index') }}" class="flex items-center gap-2.5 px-4 py-2 text-xs text-slate-200 hover:bg-purple-600/20 hover:text-amber-300 transition-colors">
                                    <i data-lucide="settings" class="w-4 h-4"></i>
                                    الإعدادات والمنطقة الزمنية
                                </a>
                            </div>
                            <div class="border-t border-purple-500/10 pt-1">
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2 text-xs text-rose-400 hover:bg-rose-500/10 transition-colors">
                                        <i data-lucide="log-out" class="w-4 h-4"></i>
                                        تسجيل الخروج
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>

                    <!-- Mobile Navigation Toggle -->
                    <button onclick="document.getElementById('mobile-nav').classList.toggle('hidden')" class="md:hidden p-2 rounded-lg text-slate-300 hover:bg-white/5">
                        <i data-lucide="menu" class="w-6 h-6"></i>
                    </button>
                </div>
            </div>
        </div>

        <!-- Mobile Nav Menu -->
        <div id="mobile-nav" class="hidden md:hidden border-t border-purple-500/15 bg-[#0b0f19] px-4 py-3 space-y-1">
            <a href="{{ route('dashboard') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('dashboard') ? 'bg-purple-600/20 text-amber-300' : 'text-slate-300' }}">لوحة التحكم</a>
            <a href="{{ route('capsules.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('capsules.index') ? 'bg-purple-600/20 text-amber-300' : 'text-slate-300' }}">جميع الكبسولات</a>
            <a href="{{ route('capsules.closed') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('capsules.closed') ? 'bg-purple-600/20 text-amber-300' : 'text-slate-300' }}">الكبسولات المغلقة</a>
            <a href="{{ route('capsules.ready') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('capsules.ready') ? 'bg-purple-600/20 text-amber-300' : 'text-slate-300' }}">المتاحة للفتح</a>
            <a href="{{ route('profile.edit') }}" class="block px-3 py-2 rounded-lg text-sm text-slate-300">الملف الشخصي</a>
            <a href="{{ route('settings.index') }}" class="block px-3 py-2 rounded-lg text-sm text-slate-300">الإعدادات</a>
            <form method="POST" action="{{ route('logout') }}" class="pt-2 border-t border-purple-500/10">
                @csrf
                <button type="submit" class="w-full text-right px-3 py-2 rounded-lg text-sm text-rose-400">تسجيل الخروج</button>
            </form>
        </div>
    </header>

    <!-- Flash Alerts -->
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full mt-4 z-30">
        @if (session('status'))
            <div class="alert-toast flex items-center justify-between p-4 mb-4 rounded-xl bg-purple-950/80 border border-purple-500/30 text-purple-200 shadow-xl transition-all">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-500/20 text-amber-400 flex items-center justify-center">
                        <i data-lucide="sparkles" class="w-4 h-4"></i>
                    </div>
                    <span class="text-sm font-medium">{{ session('status') }}</span>
                </div>
                <button onclick="this.closest('.alert-toast').remove()" class="text-purple-400 hover:text-white">
                    <i data-lucide="x" class="w-4 h-4"></i>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert-toast p-4 mb-4 rounded-xl bg-rose-950/80 border border-rose-500/30 text-rose-200 shadow-xl">
                <div class="flex items-center gap-3 mb-2">
                    <i data-lucide="alert-circle" class="w-5 h-5 text-rose-400"></i>
                    <span class="text-sm font-semibold">يرجى التحقق من الأخطاء التالية:</span>
                </div>
                <ul class="list-disc list-inside text-xs space-y-1 text-rose-300 mr-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </div>

    <!-- Main Page Content -->
    <main class="flex-1 relative z-10 max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-purple-500/10 bg-[#07090e]/80 py-8 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col sm:flex-row items-center justify-between gap-4 text-xs text-slate-400">
            <div class="flex items-center gap-2">
                <i data-lucide="hourglass" class="w-4 h-4 text-amber-400"></i>
                <span class="font-bold text-slate-200">TimeCapsule</span>
                <span>— كبسولة الزمن.</span>
            </div>
            <div>
                <span>جميع الحقوق محفوظة © {{ date('Y') }}. رسائلك وذكرياتك محفوظة بأمان للمستقبل.</span>
            </div>
        </div>
    </footer>
</body>
</html>
