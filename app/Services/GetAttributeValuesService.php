<?php

    namespace App\Services;

    use App\Models\AttributeValue;

    class GetAttributeValuesService
    {
        public function getValuesByType(String $name)
        {
            return AttributeValue::whereHas('attributeType', function ($query) use ($name) {
                $query->where('name', $name);
            })->get('name');
        }

        public function getValuesByTypeId(int $id)
        {
            return AttributeValue::whereHas('attributeType', function ($query) use ($id) {
                $query->where('id', $id);
            })->get('name');
        }
    }