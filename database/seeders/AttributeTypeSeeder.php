<?php

namespace Database\Seeders;

use App\Models\AttributeType;
use Illuminate\Database\Seeder;

class AttributeTypeSeeder extends Seeder
{
    public function run(): void
    {
        $attributeTypes = [
            'Size',
            'Color',
            'Material',
        ];

        foreach ($attributeTypes as $attributeType) {
            AttributeType::create([
                'name' => $attributeType,
            ]);
        }
    }
}
