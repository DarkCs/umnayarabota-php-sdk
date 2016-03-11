<?php

namespace umnayarabota\models;

class ProductAttributeValue
{
    /**
     * @var Attribute
     */
    public $attribute;

    /**
     * @var AttributeValue
     */
    public $value;

    /**
     * @param Attribute $attribute
     * @param AttributeValue $value
     */
    public function __construct(Attribute $attribute, AttributeValue $value)
    {
        $this->attribute = $attribute;
        $this->value = $value;
    }
}
