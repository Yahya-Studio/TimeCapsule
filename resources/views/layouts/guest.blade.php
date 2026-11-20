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
    <!-- Cosmic Ambient Background -->
    <div class="fixed inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute -top-40 right-10 w-96 h-96 bg-purple-900/20 rounded-full blur-3xl animate-float-slow"></div>
        <div class="absolute top-1/2 -left-20 w-80 h-80 bg-amber-600/10 rounded-full blur-3xl animate-float-slow" style="animation-delay: -4s;"></div>
        <div class="absolute -bottom-20 right-1/3 w-96 h-96 bg-indigo-900/20 rounded-full blur-3xl animate-float-slow" style="animation-delay: -7s;"></div>
    </div>

    <!-- Navigation Bar for Visitors -->
    <header class="sticky top-0 z-40 glass-panel border-b border-purple-500/15 bg-[#0b0f19]/80 backdrop-blur-md">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between h-16 sm:h-20">
                <a href="{{ route('home') }}" class="flex items-center gap-3 group">
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

                <div class="flex items-center gap-3">
                    @auth
                        <a href="{{ route('dashboard') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-amber-300 bg-purple-600/20 border border-purple-500/30 hover:bg-purple-600/30 transition-all">
                            الانتقال للوحة التحكم
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="px-4 py-2 rounded-xl text-sm font-medium text-slate-300 hover:text-white hover:bg-white/5 transition-all">
                            تسجيل الدخول
                        </a>
                        <a href="{{ route('register') }}" class="px-4 py-2 sm:px-5 sm:py-2.5 rounded-xl text-sm font-semibold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 transition-all shadow-md shadow-amber-500/20 hover:scale-[1.02]">
                            إنشاء حساب مجاناً
                        </a>
                    @endauth
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="flex-1 relative z-10 w-full">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="mt-auto border-t border-purple-500/10 bg-[#07090e]/90 py-10 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row items-center justify-between gap-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg bg-amber-400/10 border border-amber-400/20 flex items-center justify-center">
                        <i data-lucide="hourglass" class="w-4 h-4 text-amber-400"></i>
                    </div>
                    <div>
                        <span class="font-bold text-slate-200 text-sm">TimeCapsule</span>
                        <p class="text-xs text-slate-400">Your Past Meets Your Future – ماضيك يلتقي بمستقبلك.</p>
                    </div>
                </div>

                <div class="flex items-center gap-6 text-xs text-slate-400">
                    <a href="{{ route('home') }}#features" class="hover:text-amber-300 transition-colors">المميزات</a>
                    <a href="{{ route('home') }}#how-it-works" class="hover:text-amber-300 transition-colors">كيف يعمل</a>
                    <a href="{{ route('register') }}" class="hover:text-amber-300 transition-colors">ابدأ الآن</a>
                </div>

                <div class="text-xs text-slate-500">
                    جميع الحقوق محفوظة © {{ date('Y') }} TimeCapsule.
                </div>
            </div>
        </div>
    </footer>
</body>
</html>
