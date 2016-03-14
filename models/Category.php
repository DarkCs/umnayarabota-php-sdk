<?php

namespace umnayarabota\models;

class Category extends BaseModel
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
}
