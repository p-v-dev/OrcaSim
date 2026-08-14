<?php

namespace Database\Factories;

use App\Models\Quote;
use App\Models\QuoteItem;
use Illuminate\Database\Eloquent\Factories\Factory;

class QuoteItemFactory extends Factory
{
    protected $model = QuoteItem::class;

    public function definition(): array
    {
        $quantity = fake()->numberBetween(1, 10);
        $unitPrice = fake()->randomFloat(2, 10, 500);

        return [
            'quote_id' => Quote::factory(),
            'description' => fake()->sentence(3),
            'quantity' => $quantity,
            'unit_price' => $unitPrice,
            'line_total' => $quantity * $unitPrice,
        ];
    }
}
