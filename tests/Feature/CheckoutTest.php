<?php

namespace Tests\Feature;

use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CheckoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_cod_order_can_be_placed(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 10]);

        // Add product to cart
        session(['cart' => [
            $product->id => ['qty' => 2],
        ]]);

        $response = $this->actingAs($user)->post(route('checkout.place'), [
            'payment_method' => 'cash',
            'delivery_address' => '123 Test Street, Test City',
            'delivery_phone' => '+9601234567',
        ]);

        $response->assertRedirect();
        $this->assertStringContainsString('thank-you', $response->headers->get('Location'));
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('orders', [
            'user_id' => $user->id,
            'payment_method' => 'cash',
            'payment_status' => 'pending',
            'delivery_address' => '123 Test Street, Test City',
            'delivery_phone' => '+9601234567',
        ]);

        // Check stock was reduced
        $this->assertEquals(8, $product->fresh()->stock);
    }

    public function test_bank_transfer_order_can_be_placed_with_slip(): void
    {
        Storage::fake('public');

        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 5]);

        // Add product to cart
        session(['cart' => [
            $product->id => ['qty' => 1],
        ]]);

        $file = UploadedFile::fake()->image('payment_slip.jpg');

        $response = $this->actingAs($user)->post(route('checkout.place'), [
            'payment_method' => 'bank_transfer',
            'delivery_address' => '456 Bank Street, Bank City',
            'delivery_phone' => '+9607654321',
            'payment_slip' => $file,
        ]);

        $response->assertRedirect();
        $this->assertStringContainsString('thank-you', $response->headers->get('Location'));
        $response->assertSessionHas('success');

        $order = Order::where('user_id', $user->id)->first();

        $this->assertNotNull($order);
        $this->assertEquals('bank_transfer', $order->payment_method);
        $this->assertEquals('pending', $order->payment_status);
        $this->assertNotNull($order->payment_slip_path);

        // Check file was stored
        Storage::disk('public')->assertExists($order->payment_slip_path);
    }

    public function test_bank_transfer_order_requires_payment_slip(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 5]);

        // Add product to cart
        session(['cart' => [
            $product->id => ['qty' => 1],
        ]]);

        $response = $this->actingAs($user)->post(route('checkout.place'), [
            'payment_method' => 'bank_transfer',
            'delivery_address' => '456 Bank Street, Bank City',
            'delivery_phone' => '+9607654321',
            // Missing payment_slip
        ]);

        $response->assertSessionHasErrors(['payment_slip']);
    }

    public function test_delivery_information_is_required(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 5]);

        // Add product to cart
        session(['cart' => [
            $product->id => ['qty' => 1],
        ]]);

        $response = $this->actingAs($user)->post(route('checkout.place'), [
            'payment_method' => 'cash',
            // Missing delivery_address and delivery_phone
        ]);

        $response->assertSessionHasErrors(['delivery_address', 'delivery_phone']);
    }

    public function test_cart_is_cleared_after_successful_order(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 10]);

        // Add product to cart
        session(['cart' => [
            $product->id => ['qty' => 2],
        ]]);

        $this->assertNotEmpty(session('cart'));

        $response = $this->actingAs($user)->post(route('checkout.place'), [
            'payment_method' => 'cash',
            'delivery_address' => '123 Test Street, Test City',
            'delivery_phone' => '+9601234567',
        ]);

        $response->assertRedirect();
        $this->assertStringContainsString('thank-you', $response->headers->get('Location'));
        $this->assertEmpty(session('cart'));
    }

    public function test_insufficient_stock_prevents_order(): void
    {
        $user = User::factory()->create();
        $product = Product::factory()->create(['stock' => 1]);

        // Add more items to cart than available stock
        session(['cart' => [
            $product->id => ['qty' => 5],
        ]]);

        $response = $this->actingAs($user)->post(route('checkout.place'), [
            'payment_method' => 'cash',
            'delivery_address' => '123 Test Street, Test City',
            'delivery_phone' => '+9601234567',
        ]);

        $response->assertSessionHasErrors();
        $this->assertDatabaseMissing('orders', [
            'user_id' => $user->id,
        ]);
    }
}
