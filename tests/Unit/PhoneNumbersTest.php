<?php

namespace Tests\Unit;

use App\Models\PhoneNumber;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class PhoneNumbersTest extends TestCase
{

    use RefreshDatabase;

    public function test_unauthenticated_users_are_redirected_to_login_route()
    {
        $response = $this->get('/phone-numbers/create');
        $response->assertRedirect('/login');
    }

    public function test_authenticated_user_can_create_a_new_phone_number()
    {
        $user = User::factory()->create();
        $phoneNumber = PhoneNumber::factory()->create();
        $this->post('/phonenumbers/create',$phoneNumber->toArray());
        $this->assertEquals(1,PhoneNumber::all()->count());
    }

    public function test_authenticated_user_can_read_all_the_phone_numbers()
    {
        $user = User::factory()->create();
        $phoneNumber = PhoneNumber::factory()->create();
        $response = $this->actingAs($user)->get('/phone-numbers');
        $response->assertSee($phoneNumber->id)
            ->assertSee($phoneNumber->phonenumber)
            ->assertSee($phoneNumber->user->name);
    }

    public function test_authenticated_user_can_read_single_phone_number()
    {
        $user = User::factory()->create();
        $phoneNumber = PhoneNumber::factory()->create();
        $response = $this->actingAs($user)->get('/phone-numbers/'.$phoneNumber->id);
        $response->assertSee($phoneNumber->id)
            ->assertSee($phoneNumber->name)
            ->assertSee($phoneNumber->phonenumber)
            ->assertSee($phoneNumber->user->name)
            ->assertSee($phoneNumber->user->updated_at);
    }

    public function test_unauthenticated_users_cannot_create_a_new_phone_number()
    {
        $phoneNumber = PhoneNumber::factory()->create();
        $this->post('/phone-numbers/create',$phoneNumber->toArray())
            ->assertRedirect('/login');
    }

    public function test_authorized_user_can_update_the_phone_number()
    {
        $user = User::factory()->create();
        $phoneNumber = PhoneNumber::factory()->create(['user_id' => $user->id]);
        $phoneNumber->name = "Updated name";
        $phoneNumber->phonenumber = 12345678;
        $this->actingAs($user)->put('/phone-numbers/'.$phoneNumber->id, $phoneNumber->toArray());
        $this->assertDatabaseHas('Phone_numbers',['id'=> $phoneNumber->id , 'name' => 'Updated name']);
        $this->assertDatabaseHas('Phone_numbers',['id'=> $phoneNumber->id , 'phonenumber' => 12345678]);

    }

    public function test_unauthorized_user_cannot_update_the_phone_number()
    {
        $phoneNumber = PhoneNumber::factory()->create();
        $phoneNumber->name = "Updated name";
        $phoneNumber->phonenumber = 12345678;
        $response = $this->put('/phone-numbers/'.$phoneNumber->id, $phoneNumber->toArray());
        $response->assertStatus(302);
    }

    public function test_authorized_user_can_delete_the_phone_number()
    {
        $user = User::factory()->create();
        $phoneNumber = PhoneNumber::factory()->create(['user_id' => $user->id]);
        $phoneNumber->delete('/phone-numbers/'.$phoneNumber->id);
        $this->assertDatabaseMissing('phone_numbers',['id'=> $phoneNumber->id]);
    }

    public function test_unauthorized_user_cannot_delete_the_phone_number(){
        $user = User::factory()->create();
        $phoneNumber = PhoneNumber::factory()->create();
        $response = $this->delete('/phone-numbers/'.$phoneNumber->id);
        $response->assertStatus(302);
    }
}
