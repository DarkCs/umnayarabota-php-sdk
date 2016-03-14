<?php

namespace umnayarabota\models;

class AttributeValue extends BaseModel
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
}
