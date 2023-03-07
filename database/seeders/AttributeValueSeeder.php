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
