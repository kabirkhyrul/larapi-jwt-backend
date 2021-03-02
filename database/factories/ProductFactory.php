<?php

namespace Database\Factories;


use App\Faker\Commerce;
use App\Faker\Placeholder;
use App\Models\Product;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{

    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition(): array
    {
        $this->faker->addProvider(new Commerce($this->faker));
        $this->faker->addProvider(new Placeholder($this->faker));
        return [
            'title' => $this->faker->productName(),
            'image' => $this->faker->placeholder('250x250', 'jpg', 'f00', '000000'),
            'description' => $this->faker->realText('255'),
            'price'=>$this->faker->randomFloat(2,2, 3),
        ];
    }
}
