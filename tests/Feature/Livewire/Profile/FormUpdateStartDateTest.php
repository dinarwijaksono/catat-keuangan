<?php

namespace Tests\Feature\Livewire\Profile;

use App\Livewire\Profile\FormUpdateStartDate;
use App\Models\User;
use Database\Seeders\UserRegisterSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Livewire\Livewire;
use Tests\TestCase;

class FormUpdateStartDateTest extends TestCase
{
    public $user;

    public function setUp(): void
    {
        parent::setUp();

        $this->seed(UserRegisterSeeder::class);

        $this->user = User::select('*')->first();
        $this->actingAs($this->user);
    }

    public function test_renders_successfully()
    {
        Livewire::test(FormUpdateStartDate::class)
            ->assertStatus(200);
    }

    public function test_do_update_start_date_failed_validate_is_wrong()
    {
        Livewire::test(FormUpdateStartDate::class)
            ->set('date', '')
            ->call('doUpdateStartDate')
            ->assertHasErrors(['date' => 'required']);

        Livewire::test(FormUpdateStartDate::class)
            ->set('date', 'no valid')
            ->call('doUpdateStartDate')
            ->assertHasErrors(['date' => 'numeric']);
    }

    public function test_do_update_start_date_success()
    {
        Livewire::test(FormUpdateStartDate::class)
            ->set('date', '12')
            ->call('doUpdateStartDate');

        $this->assertDatabaseHas('start_dates', [
            'user_id'  => $this->user->id,
            'date' => '12'
        ]);
    }
}
