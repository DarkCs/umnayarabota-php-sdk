<?php

namespace umnayarabota\models;

class BaseModel
{
    public function __construct(array $config = [])
    {
        foreach ($config as $attribute => $value) {
            if (property_exists(static::class, $attribute)) {
                $this->$attribute = $value;
            }
        }
    }
}
