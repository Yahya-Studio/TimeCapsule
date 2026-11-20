@extends('layouts.guest')

@section('title', 'منصة الكبسولات والرسائل الزمنية الرقمية')

@section('content')
    <!-- Hero Section -->
    <section class="relative pt-12 pb-20 sm:pt-20 sm:pb-32 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
            <!-- Badge -->
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full glass-panel border border-amber-400/30 text-amber-300 text-xs font-semibold mb-8 shadow-lg shadow-amber-500/10">
                <i data-lucide="sparkles" class="w-4 h-4 text-amber-400"></i>
                <span>Your Past Meets Your Future – ماضيك يلتقي بمستقبلك</span>
            </div>

            <!-- Main Heading -->
            <h1 class="text-4xl sm:text-6xl lg:text-7xl font-extrabold tracking-tight text-white mb-6 leading-tight">
                احفظ لحظاتك اليوم.. <br>
                <span class="bg-gradient-to-r from-amber-400 via-purple-300 to-amber-200 bg-clip-text text-transparent">لتكتشفها في المستقبل</span>
            </h1>

            <p class="max-w-2xl mx-auto text-base sm:text-xl text-slate-300 mb-10 leading-relaxed font-normal">
                منصة <span class="font-bold text-amber-400">TimeCapsule</span> تتيح لك كتابة رسائل، تسجيل أهداف، وتخليد ذكريات ثم قفلها داخل كبسولات زمنية رقمية لا يمكن فتحها إلا عند حلول الموعد الذي تختاره بنفسك.
            </p>

            <!-- CTA Buttons -->
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mb-16">
                @auth
                    <a href="{{ route('dashboard') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-base font-bold text-slate-950 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-200 hover:from-amber-300 hover:to-amber-100 shadow-xl shadow-amber-500/25 hover:scale-[1.02] transition-all">
                        <i data-lucide="layout-dashboard" class="w-5 h-5"></i>
                        <span>الانتقال إلى لوحة التحكم</span>
                    </a>
                @else
                    <a href="{{ route('register') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-3 px-8 py-4 rounded-2xl text-base font-bold text-slate-950 bg-gradient-to-r from-amber-400 via-amber-300 to-amber-200 hover:from-amber-300 hover:to-amber-100 shadow-xl shadow-amber-500/25 hover:scale-[1.02] transition-all">
                        <i data-lucide="sparkles" class="w-5 h-5"></i>
                        <span>ابدأ رحلتك مجاناً</span>
                    </a>
                    <a href="{{ route('login') }}" 
                       class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-8 py-4 rounded-2xl text-base font-semibold text-slate-200 glass-panel hover:bg-white/10 hover:text-white transition-all border border-purple-500/30">
                        <i data-lucide="log-in" class="w-5 h-5 text-purple-300"></i>
                        <span>تسجيل الدخول</span>
                    </a>
                @endauth
            </div>

            <!-- Futuristic Mockup Preview of Capsule Vault -->
            <div class="relative max-w-4xl mx-auto">
                <div class="glass-panel rounded-3xl p-6 sm:p-8 border border-purple-500/30 shadow-2xl relative overflow-hidden bg-gradient-to-b from-[#111728]/90 to-[#0b0f19]/95 text-right">
                    <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 border-b border-purple-500/20 pb-5 mb-6">
                        <div class="flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-purple-600/30 border border-purple-500/40 flex items-center justify-center text-amber-400">
                                <i data-lucide="lock" class="w-5 h-5"></i>
                            </div>
                            <div>
                                <h3 class="text-base font-bold text-white">كبسولة: رسالة إلى نفسي بعد عام من الآن</h3>
                                <p class="text-xs text-purple-300/80">مغلقة ومحمية حتى 2027/11/20 12:00 بتوقيت صنعاء</p>
                            </div>
                        </div>
                        <span class="inline-flex items-center gap-1.5 px-3 py-1 rounded-full text-xs font-semibold bg-purple-500/20 text-purple-300 border border-purple-500/40">
                            <span class="w-2 h-2 rounded-full bg-amber-400 animate-ping"></span>
                            عداد الزمن نشط
                        </span>
                    </div>

                    <!-- Mockup Live Countdown -->
                    <div class="grid grid-cols-4 gap-3 text-center font-mono my-6">
                        <div class="bg-[#07090e] border border-purple-500/30 rounded-2xl p-3 sm:p-4">
                            <span class="block text-2xl sm:text-4xl font-extrabold text-amber-300">365</span>
                            <span class="text-xs text-slate-400 font-sans">يوماً</span>
                        </div>
                        <div class="bg-[#07090e] border border-purple-500/30 rounded-2xl p-3 sm:p-4">
                            <span class="block text-2xl sm:text-4xl font-extrabold text-purple-200">18</span>
                            <span class="text-xs text-slate-400 font-sans">ساعة</span>
                        </div>
                        <div class="bg-[#07090e] border border-purple-500/30 rounded-2xl p-3 sm:p-4">
                            <span class="block text-2xl sm:text-4xl font-extrabold text-purple-200">42</span>
                            <span class="text-xs text-slate-400 font-sans">دقيقة</span>
                        </div>
                        <div class="bg-[#07090e] border border-purple-500/30 rounded-2xl p-3 sm:p-4">
                            <span class="block text-2xl sm:text-4xl font-extrabold text-amber-400 animate-pulse">09</span>
                            <span class="text-xs text-slate-400 font-sans">ثانية</span>
                        </div>
                    </div>

                    <div class="p-4 rounded-2xl bg-purple-900/10 border border-purple-500/20 flex items-center justify-between text-xs text-slate-300">
                        <div class="flex items-center gap-2">
                            <i data-lucide="shield-check" class="w-4 h-4 text-emerald-400"></i>
                            <span>المحتوى مشفر ومقفل على الخادم ولا يمكن فتحه إلا عند انتهاء العداد.</span>
                        </div>
                        <span class="text-amber-300 font-medium">سري للغاية</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section id="how-it-works" class="py-20 border-t border-purple-500/15 relative z-10 bg-[#090d16]/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-amber-400 text-xs font-bold tracking-wider uppercase mb-2 block">آلية العمل</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">كيف تعمل كبسولة الزمن؟</h2>
                <p class="text-sm sm:text-base text-slate-300">ثلاث خطوات بسيطة لتخليد أفكارك ورسائلك واستعادتها في اللحظة المناسبة.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 text-right">
                <!-- Step 1 -->
                <div class="glass-panel rounded-3xl p-8 border border-purple-500/20 relative group hover:border-amber-400/40 transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-amber-400/15 border border-amber-400/30 text-amber-300 flex items-center justify-center mb-6 text-xl font-bold font-mono group-hover:scale-110 transition-transform">
                        01
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">اكتب رسالتك وذكرياتك</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        اكتب ما يجول بخاطرك الآن: أهدافك، مشاعرك، توقعاتك للمستقبل، أو رسالة تشجيعية لنفسك، مع إمكانية إرفاق صورة تخلد اللحظة.
                    </p>
                </div>

                <!-- Step 2 -->
                <div class="glass-panel rounded-3xl p-8 border border-purple-500/20 relative group hover:border-purple-400/40 transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-purple-600/20 border border-purple-500/40 text-purple-300 flex items-center justify-center mb-6 text-xl font-bold font-mono group-hover:scale-110 transition-transform">
                        02
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">حدد موعد الفتح في المستقبل</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        اختر التاريخ والوقت المناسبين (بعد شهر، ستة أشهر، سنة، أو أكثر). تغلق الكبسولة وتُحفظ بأمان مطلق حتى حلول الموعد.
                    </p>
                </div>

                <!-- Step 3 -->
                <div class="glass-panel rounded-3xl p-8 border border-purple-500/20 relative group hover:border-emerald-400/40 transition-all">
                    <div class="w-14 h-14 rounded-2xl bg-emerald-500/15 border border-emerald-500/30 text-emerald-300 flex items-center justify-center mb-6 text-xl font-bold font-mono group-hover:scale-110 transition-transform">
                        03
                    </div>
                    <h3 class="text-xl font-bold text-white mb-3">افتحها واسترجع الماضي</h3>
                    <p class="text-sm text-slate-300 leading-relaxed">
                        عندما يحين الموعد المحدد، يتاح لك زر الفتح لتكتشف ما كتبته قبل شهور أو سنوات وترى كم تغيرت وتطورت في رحلتك.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 border-t border-purple-500/15 relative z-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-purple-400 text-xs font-bold tracking-wider uppercase mb-2 block">المميزات</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">مصممة لتوثيق أثمن اللحظات</h2>
                <p class="text-sm sm:text-base text-slate-300">أدوات متطورة وأمان فائق لضمان سلامة ذكرياتك الشخصية.</p>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 text-right">
                <div class="glass-panel rounded-2xl p-6 border border-purple-500/20 hover:border-purple-500/40 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-purple-600/20 text-purple-300 flex items-center justify-center mb-4">
                        <i data-lucide="shield-check" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">حماية حقيقية على الخادم</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">التحقق من موعد الفتح يتم على مستوى السيرفر؛ لا يمكن قراءة الرسالة قبل موعدها مهما حاول أي شخص.</p>
                </div>

                <div class="glass-panel rounded-2xl p-6 border border-purple-500/20 hover:border-amber-400/40 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-amber-500/20 text-amber-300 flex items-center justify-center mb-4">
                        <i data-lucide="timer" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">عداد تنازلي لحظي</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">عداد تفاعلي مباشر يوضح الأيام والساعات والدقائق والثواني المتبقية مع تحديث فوري بدون إعادة تحميل.</p>
                </div>

                <div class="glass-panel rounded-2xl p-6 border border-purple-500/20 hover:border-indigo-400/40 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-indigo-600/20 text-indigo-300 flex items-center justify-center mb-4">
                        <i data-lucide="image" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">إرفاق الصور والذكريات</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">أرفق صورك الفوتوغرافية المهمة والمخطوطات لتحفظها داخل الكبسولة وتشاهدها مع الرسالة عند فتحها.</p>
                </div>

                <div class="glass-panel rounded-2xl p-6 border border-purple-500/20 hover:border-emerald-400/40 transition-all">
                    <div class="w-12 h-12 rounded-xl bg-emerald-500/20 text-emerald-300 flex items-center justify-center mb-4">
                        <i data-lucide="sparkle" class="w-6 h-6"></i>
                    </div>
                    <h4 class="text-base font-bold text-white mb-2">مراسم فتح استثنائية</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">تجربة بصرية ممتعة واحتفالية عند فتح الكبسولة تعيد لك مشاعر اللحظة التي كتبت فيها الرسالة.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Use Cases Section -->
    <section class="py-20 border-t border-purple-500/15 relative z-10 bg-[#090d16]/70">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <span class="text-amber-400 text-xs font-bold tracking-wider uppercase mb-2 block">إلهام</span>
                <h2 class="text-3xl sm:text-4xl font-bold text-white mb-4">ماذا يمكنك أن تضع في كبسولتك؟</h2>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6 text-right">
                <div class="glass-panel rounded-2xl p-6 border border-purple-500/20">
                    <span class="text-amber-400 text-lg mb-2 block">🎯</span>
                    <h4 class="text-base font-bold text-white mb-2">أهدافي السنوية</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">سجل أهدافك اليوم وحدد موعد فتحها بعد 6 أشهر أو سنة لتراجع ما حققته.</p>
                </div>
                <div class="glass-panel rounded-2xl p-6 border border-purple-500/20">
                    <span class="text-purple-400 text-lg mb-2 block">💌</span>
                    <h4 class="text-base font-bold text-white mb-2">رسالة تشجيع لنفسي</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">اكتب لنفسك المستقبلية كلمات دعم وأمل لتصلك في موعد تحدده أنت.</p>
                </div>
                <div class="glass-panel rounded-2xl p-6 border border-purple-500/20">
                    <span class="text-emerald-400 text-lg mb-2 block">🔮</span>
                    <h4 class="text-base font-bold text-white mb-2">توقعات المستقبل</h4>
                    <p class="text-xs text-slate-300 leading-relaxed">سجل توقعاتك للعالم والتكنولوجيا وحياتك الشخصية وقارنها بالواقع لاحقاً.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Bottom CTA Banner -->
    <section class="py-20 border-t border-purple-500/15 relative z-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="glass-panel rounded-3xl p-8 sm:p-14 border border-amber-400/30 text-center relative overflow-hidden bg-gradient-to-r from-purple-950/60 via-[#0d1322] to-amber-950/40">
                <h2 class="text-3xl sm:text-4xl font-extrabold text-white mb-4">جاهز لإرسال أول رسالة إلى مستقبلك؟</h2>
                <p class="text-sm sm:text-base text-slate-300 max-w-xl mx-auto mb-8 leading-relaxed">
                    انضم الآن إلى TimeCapsule، وابدأ في حفظ أفكارك الثمينة وذكرياتك داخل كبسولات مشفرة.
                </p>
                <a href="{{ route('register') }}" 
                   class="inline-flex items-center gap-3 px-8 py-4 rounded-2xl text-base font-bold text-slate-950 bg-gradient-to-r from-amber-400 to-amber-300 hover:from-amber-300 hover:to-amber-200 shadow-xl shadow-amber-500/25 hover:scale-[1.02] transition-all">
                    <i data-lucide="plus-circle" class="w-5 h-5"></i>
                    <span>أنشئ كبسولتك الأولى الآن</span>
                </a>
            </div>
        </div>
    </section>
@endsection
