<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            'XS',
            'S',
            'M',
            'L',
            'XL',
            'XXL',
            '3XL',
            '4XL',
            '5XL',
            '6XL',
            '7XL',
            '8XL',
            'One Size',
            ''
        ];


        $colors = [
            'black',
            'brown',
            'beige',
            'gray',
            'white',
            'blue',
            'petrol',
            'turquoise',
            'green',
            'olive',
            'yellow',
            'orange',
            'red',
            'pink',
            'purple',
            'gold',
            'silver',
            'multicolor',
        ];


        $materials = [
            'Braided',
            'Cashmere',
            'Cashmere (100%)',
            'Chiffon',
            'Cord',
            'Cotton',
            'Cotton (100%)',
            'Crocheted',
            'Denim',
            'Feathers',
            'Flannelette',
            'Fleece',
            'Hardshell',
            'Imitation leather',
            'Jersey',
            'Knits',
            'Lace',
            'Leather',
            'Linen',
            'Linen (100%)',
            'Lyocell (100%)',
            'Mesh',
            'Mohair',
            'Other',
            'Polyester',
            'Ribbed',
            'Rubber',
            'Satin',
            'Sequins',
            'Silk',
            'Silk (100%)',
            'Softshell',
            'Synthetic',
            'Sweat',
            'Textile',
            'Viscose',
            'Viscose (100%)',
            'Wool',
            'Wool (100%)',
        ];

        foreach ($sizes as $size) {
            AttributeValue::create([
                'name' => $size,
                'attribute_type_id' => 1,
            ]);
        }

        foreach ($colors as $color) {
            AttributeValue::create([
                'name' => $color,
                'attribute_type_id' => 2,
            ]);
        }

        foreach ($materials as $material) {
            AttributeValue::create([
                'name' => $material,
                'attribute_type_id' => 3,
            ]);
        }
    }
}
