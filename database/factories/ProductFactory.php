<?php

namespace Database\Factories;

use App\Models\Brand;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class ProductFactory extends Factory
{
    protected $model = Product::class;

    protected array $titles= [
        "Soft Joggers",
        "Cozy Hoodie",
        "Vibrant Leggings",
        "Dapper Blazer",
        "Comfy Sweater",
        "Sleek Jacket",
        "Playful Romper",
        "Chic Skirt",
        "Sporty Shorts",
        "Elegant Dress",
        "Bold Tunic",
        "Relaxed Tank",
        "Classic Cardigan",
        "Modern Jumpsuit",
        "Fluffy Robe",
        "Flowy Maxi Dress",
        "Fuzzy Socks",
        "Quirky Overalls",
        "Rugged Cargo Pants",
        "Timeless Peacoat"
    ];

    public function definition(): array
    {
        return [
            'title' => $this->faker->randomElement($this->titles),
            'description' => "This is a product description where we provide the information required for the customer to make a decision on whether to purchase the product or not. A customer can decide to purchase the product based on the information provided in this description.",
            'audience' => $this->faker->randomElement(['Men', 'Women', 'Kids', 'Unisex']),
            'sub_category_id' => SubCategory::all()->random()->id,
            'extra_info' => $this->faker->word(),
            'is_active' => $this->faker->boolean(),
            'user_id' => 1,
            'brand_id' => Brand::all()->random()->id,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
