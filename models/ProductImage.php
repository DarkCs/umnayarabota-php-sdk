<?php

namespace umnayarabota\models;

class ProductImage
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
     * Image constructor.
     * @param int $id
     * @param string $external_id
     * @param int $product_id
     * @param string $url
     * @param string $title
     */
    public function __construct($id = null, $external_id, $product_id, $url, $title = null)
    {
        $this->id = $id;
        $this->external_id = $external_id;
        $this->product_id = $product_id;
        $this->url = $url;
        $this->title = $title;
    }
}
