<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCapsuleRequest;
use App\Http\Requests\UpdateCapsuleRequest;
use App\Models\Capsule;
use App\Services\CapsuleService;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class CapsuleController extends Controller
{
    /**
     * Display a listing of all capsules.
     */
    public function index(Request $request): View
    {
        $user = $request->user();
        $tab = $request->query('tab', 'all');
        $search = $request->query('q');

        $query = $user->capsules()->where('is_archived', false);

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'ilike', "%{$search}%")
                  ->orWhere('description', 'ilike', "%{$search}%");
            });
        }

        match ($tab) {
            'closed' => $query->where('open_at', '>', now()),
            'ready' => $query->where('open_at', '<=', now())->whereNull('opened_at'),
            'opened' => $query->whereNotNull('opened_at'),
            default => null,
        };

        $capsules = $query->orderBy('open_at', 'asc')->paginate(12)->withQueryString();

        return view('capsules.index', [
            'capsules' => $capsules,
            'currentTab' => $tab,
            'search' => $search,
        ]);
    }

    /**
     * Display closed capsules only.
     */
    public function closed(Request $request): View
    {
        $user = $request->user();
        $capsules = $user->capsules()
            ->where('is_archived', false)
            ->where('open_at', '>', now())
            ->orderBy('open_at', 'asc')
            ->paginate(12);

        return view('capsules.closed', [
            'capsules' => $capsules,
        ]);
    }

    /**
     * Display ready to open capsules only.
     */
    public function ready(Request $request): View
    {
        $user = $request->user();
        $capsules = $user->capsules()
            ->where('is_archived', false)
            ->where('open_at', '<=', now())
            ->whereNull('opened_at')
            ->orderBy('open_at', 'asc')
            ->paginate(12);

        return view('capsules.ready', [
            'capsules' => $capsules,
        ]);
    }

    /**
     * Show form for creating a new capsule.
     */
    public function create(Request $request): View
    {
        $userTimezone = $request->user()->timezone ?? 'Asia/Aden';
        $defaultDate = Carbon::now($userTimezone)->addMonth()->format('Y-m-d');
        $defaultTime = '12:00';

        return view('capsules.create', [
            'defaultDate' => $defaultDate,
            'defaultTime' => $defaultTime,
        ]);
    }

    /**
     * Store newly created capsule.
     */
    public function store(StoreCapsuleRequest $request, CapsuleService $service): RedirectResponse
    {
        $capsule = $service->create(
            $request->user(),
            $request->validated(),
            $request->file('image')
        );

        return redirect()->route('capsules.show', $capsule)
            ->with('status', 'تم إغلاق الكبسولة الزمنية بنجاح! تم تشفير محتواها وحفظها بأمان حتى موعد فتحها.');
    }

    /**
     * Show capsule details.
     * Enforces strict server-side protection: if the capsule is still closed,
     * the message and image are NEVER sent in the response.
     */
    public function show(Capsule $capsule): View
    {
        Gate::authorize('view', $capsule);

        $isReady = $capsule->isReadyToOpen();
        $isOpened = $capsule->isOpened();

        // Server-side censorship for closed capsules
        $messageContent = null;
        $imageUrl = null;

        if ($isReady) {
            $messageContent = $capsule->message;
            $imageUrl = $capsule->image_url;
        }

        return view('capsules.show', [
            'capsule' => $capsule,
            'isReady' => $isReady,
            'isOpened' => $isOpened,
            'messageContent' => $messageContent,
            'imageUrl' => $imageUrl,
        ]);
    }

    /**
     * Open / Unlock a ready capsule.
     */
    public function open(Capsule $capsule, CapsuleService $service): RedirectResponse|JsonResponse
    {
        Gate::authorize('open', $capsule);

        $service->open($capsule);

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'مبروك! تم فتح الكبسولة الزمنية وقراءة محتواها.',
                'capsule_id' => $capsule->id,
            ]);
        }

        return redirect()->route('capsules.show', $capsule)
            ->with('celebrate', true)
            ->with('status', 'تهانينا! لقد حان الوقت وفتحت كبسولتك الزمنية. ها هي ذكرياتك ورسالتك تعود إليك!');
    }

    /**
     * Editing capsules is permanently forbidden.
     */
    public function edit(Capsule $capsule)
    {
        abort(403, 'الكبسولة الزمنية مغلقة ومحمية نهائياً ولا يمكن تعديلها بعد إنشائها.');
    }

    /**
     * Updating capsules is permanently forbidden.
     */
    public function update(UpdateCapsuleRequest $request, Capsule $capsule)
    {
        abort(403, 'الكبسولة الزمنية مغلقة ومحمية نهائياً ولا يمكن تعديلها بعد إنشائها.');
    }

    /**
     * Delete an unopened capsule.
     */
    public function destroy(Capsule $capsule, CapsuleService $service): RedirectResponse
    {
        Gate::authorize('delete', $capsule);

        $service->delete($capsule);

        return redirect()->route('capsules.index')
            ->with('status', 'تم حذف الكبسولة الزمنية بنجاح.');
    }
}
