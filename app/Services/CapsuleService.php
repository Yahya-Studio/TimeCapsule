<?php

namespace App\Services;

use App\Models\Capsule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class CapsuleService
{
    /**
     * Store a newly created capsule.
     */
    public function create(User $user, array $data, ?UploadedFile $image = null): Capsule
    {
        $timezone = $user->timezone ?? 'Asia/Aden';

        $openAt = Carbon::createFromFormat(
            'Y-m-d H:i',
            $data['open_date'] . ' ' . $data['open_time'],
            $timezone
        )->utc();

        $imagePath = null;
        if ($image) {
            $imagePath = $image->store('capsules', 'public');
        }

        return $user->capsules()->create([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'message' => $data['message'],
            'image' => $imagePath,
            'open_at' => $openAt,
            'is_archived' => false,
        ]);
    }

    /**
     * Update an existing closed capsule.
     */
    public function update(Capsule $capsule, array $data, ?UploadedFile $image = null, bool $removeImage = false): Capsule
    {
        $timezone = $capsule->user->timezone ?? 'Asia/Aden';

        $openAt = Carbon::createFromFormat(
            'Y-m-d H:i',
            $data['open_date'] . ' ' . $data['open_time'],
            $timezone
        )->utc();

        $imagePath = $capsule->image;

        if ($removeImage && $imagePath) {
            Storage::disk('public')->delete($imagePath);
            $imagePath = null;
        }

        if ($image) {
            if ($capsule->image) {
                Storage::disk('public')->delete($capsule->image);
            }
            $imagePath = $image->store('capsules', 'public');
        }

        $capsule->update([
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
            'message' => $data['message'],
            'image' => $imagePath,
            'open_at' => $openAt,
        ]);

        return $capsule;
    }

    /**
     * Mark capsule as opened when user unlocks it.
     */
    public function open(Capsule $capsule): Capsule
    {
        if ($capsule->isReadyToOpen() && is_null($capsule->opened_at)) {
            $capsule->update([
                'opened_at' => now(),
            ]);
        }

        return $capsule;
    }

    /**
     * Delete capsule and associated files.
     */
    public function delete(Capsule $capsule): void
    {
        if ($capsule->image) {
            Storage::disk('public')->delete($capsule->image);
        }

        $capsule->delete();
    }

    /**
     * Get aggregate statistics for the user dashboard.
     */
    public function getDashboardStats(User $user): array
    {
        $now = now();

        $baseQuery = $user->capsules()->where('is_archived', false);

        $totalCount = (clone $baseQuery)->count();
        $closedCount = (clone $baseQuery)->where('open_at', '>', $now)->count();
        $readyCount = (clone $baseQuery)->where('open_at', '<=', $now)->whereNull('opened_at')->count();
        $openedCount = (clone $baseQuery)->whereNotNull('opened_at')->count();

        $recentCapsules = (clone $baseQuery)
            ->latest('created_at')
            ->take(5)
            ->get();

        $nextCapsuleToOpen = (clone $baseQuery)
            ->where('open_at', '>', $now)
            ->orderBy('open_at', 'asc')
            ->first();

        return [
            'total' => $totalCount,
            'closed' => $closedCount,
            'ready' => $readyCount,
            'opened' => $openedCount,
            'recent' => $recentCapsules,
            'next' => $nextCapsuleToOpen,
        ];
    }
}
