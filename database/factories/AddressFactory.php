<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Address;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Address>
 */
class AddressFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Address::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $types = ['home', 'office'];
        $islands = ['Malé', 'Hulhumalé', 'Addu', 'Fuvahmulah', 'Kulhudhuffushi'];
        $atolls = ['Kaafu', 'Seenu', 'Gnaviyani', 'Haa Dhaalu', 'Baa'];

        return [
            'user_id' => User::factory(),
            'type' => $this->faker->randomElement($types),
            'label' => $this->faker->optional(0.7)->sentence(2),
            'street_address' => $this->faker->streetAddress(),
            'road_name' => $this->faker->optional(0.6)->streetName(),
            'island' => $this->faker->randomElement($islands),
            'atoll' => $this->faker->randomElement($atolls),
            'postal_code' => $this->faker->optional(0.5)->postcode(),
            'additional_notes' => $this->faker->optional(0.4)->sentence(),
            'is_default' => false,
        ];
    }

    /**
     * Indicate that the address is a home address.
     */
    public function home(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'home',
            'label' => $this->faker->optional(0.7)->randomElement(['My Home', 'Home', 'Main Residence']),
        ]);
    }

    /**
     * Indicate that the address is an office address.
     */
    public function office(): static
    {
        return $this->state(fn (array $attributes) => [
            'type' => 'office',
            'label' => $this->faker->optional(0.7)->randomElement(['Work Office', 'Office', 'Workplace']),
        ]);
    }

    /**
     * Indicate that the address is the default address.
     */
    public function default(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_default' => true,
        ]);
    }
}
