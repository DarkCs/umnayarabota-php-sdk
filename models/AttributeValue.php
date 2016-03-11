<?php

namespace umnayarabota\models;

class AttributeValue
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $attribute_id;

    /**
     * @var string
     */
    public $external_id;

    /**
     * @var string
     */
    public $value;

    /**
     * @param int $id
     * @param int $attribute_id
     * @param string $external_id
     * @param string $value
     */
    public function __construct($id = null, $attribute_id, $external_id, $value)
    {
        $this->id = $id;
        $this->attribute_id = $attribute_id;
        $this->external_id = $external_id;
        $this->value = $value;
    }
}
