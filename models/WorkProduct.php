<?php

namespace umnayarabota\models;

class WorkProduct extends BaseModel
{
    const STATUS_NEW = 1;
    const STATUS_IN_WORK = 2;
    const STATUS_FINISHED = 3;

    public $id;

    /**
     * @var Product
     */
    public $product;

    /**
     * @var Brand
     */
    public $brand;

    public $name;
    public $h1;
    public $h2;
    public $meta_title;
    public $meta_keywords;
    public $description;
    public $video;

    public $is_header_ready = 1;
    public $is_attributes_ready = 1;
    public $is_description_ready = 1;
    public $is_brand_ready = 1;
    public $is_image_ready = 1;
    public $is_video_ready = 1;

    public $is_ready;
    public $status;

    public $links = [];

    /**
     * @var ProductAttributeValue[]
     */
    public $eav = [];

    public function __construct(Product $product, array $config = [])
    {
        parent::__construct($config);

        $this->product = $product;
    }
}
