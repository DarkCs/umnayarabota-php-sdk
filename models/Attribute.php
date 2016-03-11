<?php

namespace umnayarabota\models;

class Attribute
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

    /**
     * @param int $id
     * @param string $external_id
     * @param string $name
     * @param string $unit
     */
    public function __construct($id = null, $external_id, $name, $unit = null)
    {
        $this->id = $id;
        $this->external_id = $external_id;
        $this->name = $name;
        $this->unit = $unit;
    }
}
