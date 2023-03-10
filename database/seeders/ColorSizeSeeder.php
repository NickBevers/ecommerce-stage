<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use App\Models\ColorSize;
use Illuminate\Database\Seeder;

class ColorSizeSeeder extends Seeder
{
    public function run(): void
    {
        $colors = AttributeValue::get()->where('attribute_type_id', 2);
        $sizes = AttributeValue::get()->where('attribute_type_id', 1);

        foreach ($colors as $color) {
            foreach ($sizes as $size) {
                ColorSize::create([
                    'color_id' => $color->id,
                    'size_id' => $size->id,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
