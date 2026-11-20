<?php

namespace Tests\Feature;

use App\Models\Capsule;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CapsuleTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;
    protected User $otherUser;

    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create([
            'timezone' => 'Asia/Aden',
        ]);

        $this->otherUser = User::factory()->create([
            'timezone' => 'Asia/Aden',
        ]);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get(route('dashboard'));
        $response->assertRedirect(route('login'));

        $response = $this->get(route('capsules.index'));
        $response->assertRedirect(route('login'));
    }

    public function test_user_can_register_without_terms_checkbox(): void
    {
        $response = $this->post(route('register'), [
            'name' => 'مستخدم جديد',
            'email' => 'newuser@example.com',
            'password' => 'secret1234',
            'password_confirmation' => 'secret1234',
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertDatabaseHas('users', [
            'email' => 'newuser@example.com',
        ]);
    }

    public function test_user_can_view_dashboard_and_capsules(): void
    {
        $response = $this->actingAs($this->user)->get(route('dashboard'));
        $response->assertStatus(200);
        $response->assertSee('لوحة التحكم');

        $response = $this->actingAs($this->user)->get(route('capsules.index'));
        $response->assertStatus(200);
    }

    public function test_user_can_create_capsule_with_future_date(): void
    {
        $futureDate = Carbon::now('Asia/Aden')->addDays(15);

        $response = $this->actingAs($this->user)->post(route('capsules.store'), [
            'title' => 'رسالتي المستقبلية',
            'description' => 'وصف الكبسولة',
            'message' => 'هذا محتوى سري جداً للمستقبل.',
            'open_date' => $futureDate->format('Y-m-d'),
            'open_time' => '14:30',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('capsules', [
            'user_id' => $this->user->id,
            'title' => 'رسالتي المستقبلية',
        ]);
    }

    public function test_capsule_cannot_be_created_with_past_date(): void
    {
        $pastDate = Carbon::now('Asia/Aden')->subDays(2);

        $response = $this->actingAs($this->user)->post(route('capsules.store'), [
            'title' => 'تاريخ سابق غير مسموح',
            'message' => 'محتوى الرسالة',
            'open_date' => $pastDate->format('Y-m-d'),
            'open_time' => '10:00',
        ]);

        $response->assertSessionHasErrors('open_datetime');
        $this->assertDatabaseMissing('capsules', [
            'title' => 'تاريخ سابق غير مسموح',
        ]);
    }

    public function test_server_does_not_reveal_message_before_open_at(): void
    {
        $secretMessage = 'CONFIDENTIAL_SECRET_TOKEN_XYZ';
        $capsule = Capsule::create([
            'user_id' => $this->user->id,
            'title' => 'كبسولة مغلقة لا يجب كشفها',
            'message' => $secretMessage,
            'open_at' => Carbon::now('Asia/Aden')->addDays(30)->utc(),
            'is_archived' => false,
        ]);

        $response = $this->actingAs($this->user)->get(route('capsules.show', $capsule));

        $response->assertStatus(200);
        $response->assertSee('محتوى الكبسولة مؤصد ومحمي');
        $response->assertDontSee($secretMessage);
    }

    public function test_server_reveals_message_when_open_at_has_passed(): void
    {
        $secretMessage = 'REVEALED_PAST_MEMORIES_123';
        $capsule = Capsule::create([
            'user_id' => $this->user->id,
            'title' => 'كبسولة مستحقة الفتح',
            'message' => $secretMessage,
            'open_at' => Carbon::now('Asia/Aden')->subHours(1)->utc(),
            'opened_at' => null,
            'is_archived' => false,
        ]);

        $response = $this->actingAs($this->user)->get(route('capsules.show', $capsule));
        $response->assertStatus(200);
        $response->assertSee('حان الموعد المنتظر!');

        $openResponse = $this->actingAs($this->user)->post(route('capsules.open', $capsule));
        $openResponse->assertRedirect(route('capsules.show', $capsule));

        $responseAfter = $this->actingAs($this->user)->get(route('capsules.show', $capsule));
        $responseAfter->assertStatus(200);
        $responseAfter->assertSee($secretMessage);
    }

    public function test_user_cannot_view_or_manipulate_another_users_capsule(): void
    {
        $capsule = Capsule::create([
            'user_id' => $this->otherUser->id,
            'title' => 'كبسولة سارة الخاصة',
            'message' => 'رسالة خاصة جداً',
            'open_at' => Carbon::now()->addDays(10),
            'is_archived' => false,
        ]);

        $response = $this->actingAs($this->user)->get(route('capsules.show', $capsule));
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->delete(route('capsules.destroy', $capsule));
        $response->assertStatus(403);
    }

    public function test_user_cannot_edit_capsule_at_all(): void
    {
        // Once created, capsules can NEVER be edited (strictly sealed until opened or deleted)
        $capsule = Capsule::create([
            'user_id' => $this->user->id,
            'title' => 'كبسولة مؤصدة',
            'message' => 'رسالة أصلية',
            'open_at' => Carbon::now()->addDays(10),
            'is_archived' => false,
        ]);

        $response = $this->actingAs($this->user)->get(route('capsules.edit', $capsule));
        $response->assertStatus(403);

        $response = $this->actingAs($this->user)->put(route('capsules.update', $capsule), [
            'title' => 'محاولة تعديل مرفوضة',
            'message' => 'رسالة معدلة',
            'open_date' => Carbon::now()->addDays(20)->format('Y-m-d'),
            'open_time' => '12:00',
        ]);
        $response->assertStatus(403);
    }

    public function test_user_can_delete_unopened_capsule(): void
    {
        $capsule = Capsule::create([
            'user_id' => $this->user->id,
            'title' => 'كبسولة للحذف',
            'message' => 'محتوى للحذف',
            'open_at' => Carbon::now()->addDays(5),
            'is_archived' => false,
        ]);

        $response = $this->actingAs($this->user)->delete(route('capsules.destroy', $capsule));
        $response->assertRedirect(route('capsules.index'));
        $this->assertDatabaseMissing('capsules', [
            'id' => $capsule->id,
        ]);
    }
}
