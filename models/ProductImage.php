<?php

namespace umnayarabota\models;

class ProductImage extends BaseModel
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
     * @var int
     */
    public $product_id;

    /**
     * @var string
     */
    public $url;

    /**
     * @var string
     */
    public $title;

    /**
     * @var int
     */
    public $position;
}
