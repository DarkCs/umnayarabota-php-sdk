<?php

namespace umnayarabota\models;

class ProductAttributeValue extends BaseModel
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
     * ProductAttributeValue constructor.
     * @param Attribute $attribute
     * @param AttributeValue $value
     * @param array $config
     */
    public function __construct(Attribute $attribute, AttributeValue $value, array $config = [])
    {
        parent::__construct($config);

        $this->attribute = $attribute;
        $this->value = $value;
    }
}
