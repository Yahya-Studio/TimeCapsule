# ⏳ TimeCapsule — كبسولة الزمن
> **"Your Past Meets Your Future — ماضيك يلتقي بمستقبلك"**

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" alt="Laravel 12" />
  <img src="https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white" alt="PHP 8.2+" />
  <img src="https://img.shields.io/badge/PostgreSQL-18+-4169E1?style=for-the-badge&logo=postgresql&logoColor=white" alt="PostgreSQL" />
  <img src="https://img.shields.io/badge/Tailwind_CSS-v4-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" alt="Tailwind CSS" />
  <img src="https://img.shields.io/badge/Vanilla_JS-ES6+-F7DF1E?style=for-the-badge&logo=javascript&logoColor=black" alt="JavaScript" />
  <img src="https://img.shields.io/badge/Vite-Build_Tool-646CFF?style=for-the-badge&logo=vite&logoColor=white" alt="Vite" />
  <img src="https://img.shields.io/badge/License-MIT-amber?style=for-the-badge" alt="License" />
</p>

---

## 📖 نبذة عن المشروع

**TimeCapsule (كبسولة الزمن)** هي منصة ويب رقمية متكاملة تتيح للمستخدمين تدوين رسائلهم، ذكرياتهم، وأهدافهم وتطلعاتهم الشخصية، ثم إغلاقها بإحكام داخل كبسولات زمنية مشفرة ومؤصدة لا يمكن فتحها أو قراءة محتواها إلا عند حلول تاريخ ووقت مستقبلي يحدده المستخدم بنفسه.

تم تصميم المنصة بهوية بصرية كونية فاخرة (Midnight Cosmic) تعكس مفهوم الزمن والذكريات، معتمدة على أحدث معايير الأمان والتصميم التفاعلي اللحظي.

---

## ✨ المميزات والخصائص الجوهرية

- 🔒 **ختم دائم وغير قابل للتعديل (Permanently Sealed):**
  بمجرد إنشاء الكبسولة وتحديد موعد فتحها، تصبح مغلقة ومحمية نهائياً ولا يمكن للمستخدم تعديل نصها أو تاريخها مطلقاً (إما الانتظار حتى يحين الموعد أو حذفها بالكامل قبل الفتح)، لضمان أصالة الذكرى وعدم التلاعب بالمشاعر أو الأهداف المسجلة.
- 🛡️ **حماية أمنية مشددة على السيرفر (Backend Security):**
  يتحقق الخادم من شرط `open_at <= now()` قبل إرجاع أي حرف من الرسالة أو الصورة المرفقة إلى المتصفح؛ محتوى الكبسولة محجوب ومحمي برمجياً ضد أي محاولة استعراض أو تلاعب بطلبات HTTP.
- ⏱️ **عداد تنازلي تفاعلي ولحظي (Real-time Live Countdown):**
  محرك جافاسكريبت نقي (Vanilla JS) دقيق يحسب الأيام والساعات والدقائق والثواني المتبقية مع تحديث فوري وسلس كل ثانية دون الحاجة لإعادة تحميل الصفحة.
- 🎁 **مراسم فتح استثنائية (Unlocking Ceremony):**
  عند انقضاء العداد وحلول الموعد الموعود، يتحول مظهر الكبسولة تلقائياً إلى "متاحة للفتح الآن" مصحوبة بتأثيرات بصرية واحتفالية تكشف الرسالة المسترجعة من الماضي.
- 📊 **لوحة تحكم إحصائية ذكية (User Dashboard):**
  ملخص فوري لعدد الكبسولات (الإجمالي، المغلقة، الجاهزة للفتح، المفتوحة)، وبطاقة بارزة لأقرب كبسولة موعداً للفتح مع عدادها المباشر.
- 🖼️ **إرفاق الصور والذكريات:**
  إمكانية إرفاق صورة تذكارية مع كل كبسولة، يتم حفظها وحجبها حتى فتح الكبسولة.
- 👤 **إدارة الملف الشخصي والإعدادات:**
  تعديل الاسم والبريد وتحديث الصورة الرمزية، تغيير كلمة المرور، وضبط المنطقة الزمنية المفضلة للمستخدم (مع اعتماد `Asia/Aden` افتراضياً).

---

## 🛠 التقنيات المستخدمة في البناء

| الطبقة | التقنية | الاستخدام |
| :--- | :--- | :--- |
| **Backend Framework** | **Laravel 12** | بنية نظيفة ومعمارية MVC مفصولة المسؤوليات |
| **Programming Language**| **PHP 8.2+** | كتابة المنطق البرمجي والخدمات |
| **Database** | **PostgreSQL** | إدارة البيانات والعلاقات والجداول والفهارس |
| **Frontend Templates** | **Blade Templates** | قوالب العرض ومكونات الواجهة القابلة لإعادة الاستخدام |
| **Styling** | **Tailwind CSS v4** | تصميم أنيق وعصري بنظام ألوان داكن مع دعم كامل للـ RTL |
| **Interactivity** | **Vanilla JavaScript** | محرك العداد التنازلي والمؤثرات والنوافذ التفاعلية |
| **Icons** | **Lucide Icons** | أيقونات عصرية وخفيفة في كامل التطبيق |
| **Bundler** | **Vite** | تجميع وبناء ملفات الواجهة الأمامية بسرعة فائقة |

---

## 🗄️ قاعدة البيانات وطرق التثبيت

تم بناء قاعدة البيانات بالكامل باستخدام **PostgreSQL**، وتتضمن الجداول الأساسية:
- `users`: بيانات المستخدمين، كلمات المرور المشفرة، الصورة الشخصية، والمنطقة الزمنية.
- `capsules`: الكبسولات الزمنية، العنوان، الوصف، الرسالة السرية، مسار الصورة، موعد الفتح (`open_at`)، موعد الفتح الفعلي (`opened_at`)، وحالة الأرشفة.
- `password_reset_tokens`: رموز استعادة كلمة المرور المشفرة.
- `sessions` & `cache`: لإدارة الجلسات السريعة.

### خيارات إعداد وتجهيز قاعدة البيانات:

#### 1️⃣ الطريقة الأولى: عبر أوامر ترحيل Laravel (Migrations) — [موصى بها]
بعد ضبط إعدادات الاتصال في ملف `.env`، نفّذ الأمر التالي لإنشاء كافة الجداول والفهارس تلقائياً:

```bash
php artisan migrate
```

لإعادة ضبط الجداول وإنشائها من الصفر في أي وقت:
```bash
php artisan migrate:fresh
```

---

#### 2️⃣ الطريقة الثانية: عبر ملف الاستيراد المباشر `.sql`
تم تجهيز ملف SQL متكامل يحتوي على المخطط الهيكلي لقاعدة البيانات وكافة الجداول والقيود والفهارس.

**مكان وجود الملف في المشروع:**
- مسار قاعدة البيانات الداخلي: `database/timecapsule.sql`
- المجلد الرئيسي للمشروع: `timecapsule.sql`

**طريقة استيراد الملف إلى PostgreSQL:**
```bash
# إنشاء قاعدة البيانات في PostgreSQL (إن لم تكن منشأة)
createdb -U postgres timecapsule

# استيراد ملف الـ SQL مباشرة
psql -U postgres -d timecapsule -f database/timecapsule.sql
```

---

## 🚀 خطوات التثبيت والتشغيل المحلي

### 1. استنساخ المستودع والدخول للمجلد:
```bash
git clone <repository-url>
cd TimeCapsule
```

### 2. تثبيت اعتماديات الـ PHP والـ Node:
```bash
composer install
npm install
```

### 3. إعداد ملف البيئة والمفتاح السري:
انسخ ملف `.env.example` إلى `.env`:
```bash
cp .env.example .env
php artisan key:generate
```

### 4. ربط قاعدة بيانات PostgreSQL:
افتح ملف `.env` وتأكد من إعداد بيانات الاتصال بقاعدة بياناتك:
```env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=timecapsule
DB_USERNAME=your_postgres_user
DB_PASSWORD=your_postgres_password
```

### 5. إنشاء الجداول وتفعيل التخزين:
```bash
# تشغيل أوامر التهجير
php artisan migrate

# إنشاء الرابط الرمزي للملفات المرفوعة
php artisan storage:link
```

### 6. بناء أصول الواجهة (Vite):
```bash
npm run build
```

### 7. تشغيل خادم التطوير:
```bash
php artisan serve
```
افتح المتصفح وتوجه إلى: `http://127.0.0.1:8000`

---

## 🧪 تشغيل الاختبارات الآلية (Automated Tests)

يحتوي المشروع على حزمة اختبارات شاملة تغطي:
- إنشاء الكبسولات والتحقق من التواريخ المستقبلية.
- منع تعديل الكبسولة المغلقة نهائياً وتأكيد ختمها الدائم.
- منع إرجاع الرسالة من السيرفر قبل حلول موعدها.
- كشف المحتوى بعد حلول الموعد ومراسم الفتح.
- حماية خصوصية المستخدمين ومنع الوصول لكبسولات الآخرين.
- حذف الكبسولات غير المفتوحة.

لتشغيل الاختبارات:
```bash
php artisan test
```

---

## 📁 هيكلية ملفات المشروع

```text
TimeCapsule/
├── app/
│   ├── Http/
│   │   ├── Controllers/        # وحدات التحكم (Auth, Capsule, Dashboard, Profile, Settings)
│   │   └── Requests/           # طلبات التحقق من صحة البيانات (Form Requests)
│   ├── Models/                 # نماذج Eloquent (User, Capsule)
│   ├── Policies/               # سياسات الأمان وتفويض الصلاحيات (CapsulePolicy)
│   └── Services/               # طبقة الخدمات لمعالجة منطق العمل (CapsuleService)
├── database/
│   ├── migrations/             # ملفات الترحيل المهيكلة
│   └── timecapsule.sql         # ملف SQL الجاهز للاستيراد المباشر
├── resources/
│   ├── css/app.css             # تنسيقات Tailwind CSS والهوية الداكنة
│   ├── js/app.js               # محرك العداد التنازلي التفاعلي وأيقونات Lucide
│   └── views/                  # شاشات وقوالب Blade ومكونات العرض
├── timecapsule.sql             # ملف SQL بقاعدة البيانات في المجلد الرئيسي
├── LICENSE                     # رخصة المشروع (MIT License)
└── tests/                      # الاختبارات الآلية (Feature Tests)
```

---

## 📄 الترخيص (License)

هذا المشروع مرخص بموجب رخصة **MIT**. راجع ملف [LICENSE](LICENSE) لمزيد من التفاصيل.

Copyright (c) 2026 **Yahya-Studio**.
