<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Models\Address;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AddressManagementTest extends TestCase
{
    use RefreshDatabase;

    protected User $user;

    protected function setUp(): void
    {
        parent::setUp();

        // Create a test user
        $this->user = User::factory()->create();

        // Seed Maldives data
        $this->artisan('db:seed', ['--class' => 'MaldivesDataSeeder']);
    }

    public function test_user_can_view_addresses_index(): void
    {
        $response = $this->actingAs($this->user)->get('/addresses');

        $response->assertStatus(200);
        $response->assertViewIs('addresses.index');
    }

    public function test_user_can_create_home_address(): void
    {
        $addressData = [
            'type' => 'home',
            'label' => 'My Home',
            'street_address' => 'House No. 123, Villa Paradise',
            'road_name' => 'Ameer Ahmed Magu',
            'island' => 'Malé',
            'atoll' => 'Kaafu',
            'postal_code' => '20001',
            'additional_notes' => 'Near the mosque',
            'is_default' => true,
        ];

        $response = $this->actingAs($this->user)
            ->post('/addresses', $addressData);

        $response->assertRedirect('/addresses');
        $response->assertSessionHas('success', 'Address added successfully!');

        $this->assertDatabaseHas('addresses', [
            'user_id' => $this->user->id,
            'type' => 'home',
            'label' => 'My Home',
            'street_address' => 'House No. 123, Villa Paradise',
            'island' => 'Malé',
            'atoll' => 'Kaafu',
            'is_default' => true,
        ]);
    }

    public function test_user_can_create_office_address(): void
    {
        $addressData = [
            'type' => 'office',
            'label' => 'Work Office',
            'street_address' => 'Office Building, Floor 2',
            'road_name' => 'Boduthakurufaanu Magu',
            'island' => 'Malé',
            'atoll' => 'Kaafu',
            'postal_code' => '20002',
            'additional_notes' => 'Reception desk',
            'is_default' => false,
        ];

        $response = $this->actingAs($this->user)
            ->post('/addresses', $addressData);

        $response->assertRedirect('/addresses');
        $response->assertSessionHas('success', 'Address added successfully!');

        $this->assertDatabaseHas('addresses', [
            'user_id' => $this->user->id,
            'type' => 'office',
            'label' => 'Work Office',
            'street_address' => 'Office Building, Floor 2',
            'island' => 'Malé',
            'atoll' => 'Kaafu',
            'is_default' => false,
        ]);
    }

    public function test_user_can_update_address(): void
    {
        $address = Address::factory()->create([
            'user_id' => $this->user->id,
            'type' => 'home',
            'label' => 'Old Label',
            'street_address' => 'Old Address',
        ]);

        $updateData = [
            'type' => 'home',
            'label' => 'Updated Home',
            'street_address' => 'Updated Address',
            'road_name' => 'New Road',
            'island' => 'Malé',
            'atoll' => 'Kaafu',
            'postal_code' => '20003',
            'additional_notes' => 'Updated notes',
            'is_default' => true,
        ];

        $response = $this->actingAs($this->user)
            ->put("/addresses/{$address->id}", $updateData);

        $response->assertRedirect('/addresses');
        $response->assertSessionHas('success', 'Address updated successfully!');

        $this->assertDatabaseHas('addresses', [
            'id' => $address->id,
            'user_id' => $this->user->id,
            'label' => 'Updated Home',
            'street_address' => 'Updated Address',
            'is_default' => true,
        ]);
    }

    public function test_user_can_delete_address(): void
    {
        $address = Address::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete("/addresses/{$address->id}");

        $response->assertRedirect('/addresses');
        $response->assertSessionHas('success', 'Address deleted successfully!');

        $this->assertDatabaseMissing('addresses', [
            'id' => $address->id,
        ]);
    }

    public function test_user_can_set_address_as_default(): void
    {
        // Create two addresses
        $address1 = Address::factory()->create([
            'user_id' => $this->user->id,
            'type' => 'home',
            'is_default' => true,
        ]);

        $address2 = Address::factory()->create([
            'user_id' => $this->user->id,
            'type' => 'home',
            'is_default' => false,
        ]);

        // Set address2 as default
        $response = $this->actingAs($this->user)
            ->post("/addresses/{$address2->id}/set-default");

        $response->assertRedirect('/addresses');
        $response->assertSessionHas('success', 'Default address updated!');

        // Check that address2 is now default and address1 is not
        $this->assertDatabaseHas('addresses', [
            'id' => $address2->id,
            'is_default' => true,
        ]);

        $this->assertDatabaseHas('addresses', [
            'id' => $address1->id,
            'is_default' => false,
        ]);
    }

    public function test_user_cannot_access_other_users_addresses(): void
    {
        $otherUser = User::factory()->create();
        $address = Address::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get("/addresses/{$address->id}/edit");

        $response->assertStatus(403);
    }

    public function test_user_cannot_update_other_users_addresses(): void
    {
        $otherUser = User::factory()->create();
        $address = Address::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->put("/addresses/{$address->id}", [
                'type' => 'home',
                'street_address' => 'Hacked Address',
                'island' => 'Malé',
                'atoll' => 'Kaafu',
            ]);

        $response->assertStatus(403);
    }

    public function test_user_cannot_delete_other_users_addresses(): void
    {
        $otherUser = User::factory()->create();
        $address = Address::factory()->create([
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($this->user)
            ->delete("/addresses/{$address->id}");

        $response->assertStatus(403);
    }

    public function test_address_validation_requires_required_fields(): void
    {
        $response = $this->actingAs($this->user)
            ->post('/addresses', []);

        $response->assertSessionHasErrors([
            'type',
            'street_address',
            'island',
            'atoll',
        ]);
    }

    public function test_address_type_must_be_valid(): void
    {
        $response = $this->actingAs($this->user)
            ->post('/addresses', [
                'type' => 'invalid_type',
                'street_address' => 'Test Address',
                'island' => 'Malé',
                'atoll' => 'Kaafu',
            ]);

        $response->assertSessionHasErrors(['type']);
    }

    public function test_registration_flow_shows_address_setup(): void
    {
        $response = $this->actingAs($this->user)
            ->get('/setup-addresses');

        $response->assertStatus(200);
        $response->assertViewIs('auth.address-setup');
    }

    public function test_registration_flow_redirects_if_user_has_addresses(): void
    {
        // Create an address for the user
        Address::factory()->create([
            'user_id' => $this->user->id,
        ]);

        $response = $this->actingAs($this->user)
            ->get('/setup-addresses');

        $response->assertRedirect('/dashboard');
    }

    public function test_user_can_complete_address_setup(): void
    {
        $addressData = [
            'home_street_address' => 'Home Street 123',
            'home_road_name' => 'Home Road',
            'home_island' => 'Malé',
            'home_atoll' => 'Kaafu',
            'home_postal_code' => '20001',
            'home_additional_notes' => 'Home notes',
            'office_street_address' => 'Office Street 456',
            'office_road_name' => 'Office Road',
            'office_island' => 'Malé',
            'office_atoll' => 'Kaafu',
            'office_postal_code' => '20002',
            'office_additional_notes' => 'Office notes',
        ];

        $response = $this->actingAs($this->user)
            ->post('/setup-addresses', $addressData);

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('success', 'Welcome! Your addresses have been saved. You can now shop with ease!');

        // Check that both addresses were created
        $this->assertDatabaseHas('addresses', [
            'user_id' => $this->user->id,
            'type' => 'home',
            'street_address' => 'Home Street 123',
            'is_default' => true,
        ]);

        $this->assertDatabaseHas('addresses', [
            'user_id' => $this->user->id,
            'type' => 'office',
            'street_address' => 'Office Street 456',
            'is_default' => false,
        ]);
    }

    public function test_user_can_skip_address_setup(): void
    {
        $response = $this->actingAs($this->user)
            ->get('/skip-address-setup');

        $response->assertRedirect('/dashboard');
        $response->assertSessionHas('info', 'You can add your addresses later from your profile.');
    }
}
