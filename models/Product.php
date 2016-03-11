<?php

namespace umnayarabota\models;

class Product
{
    public $id;
    public $category_id;
    public $brand_id;
    public $external_id;
    public $url;
    public $name;
    public $description;
    public $sku;
    public $barcode;
    public $meta_title;
    public $meta_keywords;
    public $video;

    /**
     * @var Category
     */
    public $category;

    /**
     * @var Brand
     */
    public $brand;

    /**
     * @var ProductImage[]
     */
    public $images = [];

    /**
     * @var ProductAttributeValue[]
     */
    public $eav = [];

    public function __construct($config = [])
    {
        foreach ($config as $attribute => $value) {
            $this->$attribute = $value;
        }
    }
}
