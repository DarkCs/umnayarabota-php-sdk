<?php

namespace umnayarabota\models;

class WorkProduct
{
    public $id;

    /**
     * @var Product
     */
    public $product;

    public $is_header_ready = 1;
    public $is_attributes_ready = 1;
    public $is_description_ready = 1;
    public $is_brand_ready = 1;
    public $is_image_ready = 1;
    public $is_video_ready = 1;

    public $links = [];

    public function __construct(Product $product, $config = [])
    {
        $this->product = $product;
        foreach ($config as $attribute => $value) {
            $this->$attribute = $value;
        }
    }
}
