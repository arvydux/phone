<?php

namespace Tests\Feature;

use App\Models\PhoneNumber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhoneNumbersTest extends TestCase
{

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_unauthenticated_users_are_redirected_to_login_route()
    {
        dd($this->get('http://localhost/phonenumbers/create'));
        $response = $this->get('http://localhost/phonenumbers/create');
        $response->assertRedirect('http://localhost/login');
    }

    public function test_authenticated_users_can_create_a_new_phone_number()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)->get('/phonenumbers/create');
        $response->assertSee('Create a phone number')
                 ->assertSee('Add a phone number');
    }

    public function test_authenticated_user_can_read_all_the_phone_numbers()
    {
        $user = User::factory()->create();
        $phoneNumber = PhoneNumber::factory()->create();
        $response = $this->actingAs($user)->get('/phonenumbers');
        $response->assertSee($phoneNumber->id)
                 ->assertSee($phoneNumber->phonenumber)
                 ->assertSee($phoneNumber->user->name);
    }

    public function test_authenticated_user_can_read_single_phone_number()
    {
        $user = User::factory()->create();
        $phoneNumber = PhoneNumber::factory()->create();
        $response = $this->actingAs($user)->get('/phonenumbers/'.$phoneNumber->id);
        $response->assertSee($phoneNumber->id)
                 ->assertSee($phoneNumber->name)
                 ->assertSee($phoneNumber->phonenumber)
                 ->assertSee($phoneNumber->user->name)
                 ->assertSee($phoneNumber->user->updated_at);
    }

    public function test_authenticated_user_can_create_a_new_phone_number()
    {
        $user = User::factory()->create();
        $phoneNumber = PhoneNumber::factory()->create();
        $this->post('/phonenumbers/create',$phoneNumber->toArray());
        $this->assertEquals(1,PhoneNumbers::all()->count());
    }
}
