<?php

namespace Database\Seeders;

use App\Models\AttributeValue;
use Illuminate\Database\Seeder;

class AttributeValueSeeder extends Seeder
{
    public function run(): void
    {
        $sizes = [
            'One Size',
            'XXS',
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
            '23',
            '24',
            '25',
            '26',
            '27',
            '28',
            '29',
            '30',
            '31',
            '32',
            '33',
            '34',
            '35',
            '36',
            '37',
            '38',
            '39',
            '40',
            '41',
            '42',
            '43',
            '44',
            '45',
            '46',
            '47',
            '48',
            '49',
            '50',
            '52',
            '54',
            '56',
            '58',
            '60',
            '62',
            '64',
            '66',
            '68',
            '70',
            '90',
            '94',
            '98',
            '102',
            '106',
            '110',
        ];


        $colors = [
            [
                "black",
                "#000000"
            ],
            [
                "brown",
                "#a52a2a"
            ],
            [
                "beige",
                "#f5f5dc"
            ],
            [
                "gray",
                "#808080"
            ],
            [
                "white",
                "#ffffff"
            ],
            [
                "blue",
                "#0000ff"
            ],
            [
                "petrol",
                "#008080"
            ],
            [
                "turquoise",
                "#40e0d0"
            ],
            [
                "green",
                "#008000"
            ],
            [
                "olive",
                "#808000"
            ],
            [
                "yellow",
                "#ffff00"
            ],
            [
                "orange",
                "#ffa500"
            ],
            [
                "red",
                "#ff0000"
            ],
            [
                "pink",
                "#ffc0cb"
            ],
            [
                "purple",
                "#800080"
            ],
            [
                "gold",
                "#ffd700"
            ],
            [
                "silver",
                "#c0c0c0"
            ]
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
                'name' => $color[0],
                'attribute_type_id' => 2,
                'color_value' => $color[1],
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
