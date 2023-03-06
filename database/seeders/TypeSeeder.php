<?php

namespace Database\Seeders;

use App\Models\AttributeType;
use Illuminate\Database\Seeder;

class TypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            'color',
            'size',
            'material',
        ];

        foreach ($types as $type) {
            AttributeType::create([
                'name' => $type,
            ]);
        }


    }
}
