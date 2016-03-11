<?php

namespace umnayarabota\models;

class Category
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var int
     */
    public $parent_id;

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
     * @param int $parent_id
     * @param string $external_id
     * @param string $name
     */
    public function __construct($id = null, $parent_id = null, $external_id, $name)
    {
        $this->id = $id;
        $this->parent_id = $parent_id;
        $this->external_id = $external_id;
        $this->name = $name;
    }
}
