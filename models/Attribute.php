<?php

namespace umnayarabota\models;

class Attribute extends BaseModel
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $external_id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $unit;
}
