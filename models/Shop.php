<?php

namespace umnayarabota\models;

class Shop
{
    /**
     * @var int
     */
    public $id;

    /**
     * @var string
     */
    public $name;

    /**
     * @var string
     */
    public $url;

    /**
     * @param $id
     * @param $name
     * @param $url
     */
    public function __construct($id = null, $name, $url = null)
    {
        $this->id = $id;
        $this->name = $name;
        $this->url = $url;
    }
}
