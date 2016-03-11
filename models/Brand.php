<?php

namespace umnayarabota\models;

class Brand
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
     * @param int $id
     * @param string $external_id
     * @param string $name
     */
    public function __construct($id = null, $external_id, $name)
    {
        $this->id = $id;
        $this->external_id = $external_id;
        $this->name = $name;
    }
}
