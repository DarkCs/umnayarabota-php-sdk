<?php

namespace umnayarabota;

use GuzzleHttp\Exception\ClientException;
use Psr\Http\Message\ResponseInterface;
use umnayarabota\helpers\ArrayHelper;
use umnayarabota\models\Attribute;
use umnayarabota\models\AttributeValue;
use umnayarabota\models\Brand;
use umnayarabota\models\Category;
use umnayarabota\models\Product;
use umnayarabota\models\ProductAttributeValue;
use umnayarabota\models\ProductImage;
use umnayarabota\models\Shop;
use umnayarabota\models\WorkProduct;

class Client
{
    public $apiUrl = 'http://umnayarabota.ru/api';
    public $apiAccessToken;

    private $httpClient;

    public function __construct($apiAccessToken, $apiUrl = null)
    {
        $this->apiAccessToken = $apiAccessToken;

        if ($apiUrl) {
            $this->apiUrl = $apiUrl;
        }
    }

    public function createShop(Shop $shop)
    {
        try {
            $response = $this->getHttpClient()->post($this->getApiUrl('shop/shops'), [
                'json' => [
                    'name' => $shop->name,
                    'url' => $shop->getUrl(),
                ]
            ]);

            if ($id = $this->getResponseValue($response, 'id')) {
                $shop->id = $id;
                return $shop;
            }
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }

        return false;
    }

    public function getHttpClient()
    {
        if ($this->httpClient) {
            return $this->httpClient;
        }

        $this->httpClient = new \GuzzleHttp\Client();

        return $this->httpClient;
    }

    public function getApiUrl($route, Shop $shop = null, $params = [])
    {
        return sprintf('%s/%s?access-token=%s&shop_id=%s&%s', $this->apiUrl, $route, $this->apiAccessToken, ($shop ? $shop->id : ''), http_build_query($params));
    }

    public function getResponseValue(ResponseInterface $response, $attribute = null)
    {
        $data = json_decode($response->getBody(), true);

        if ($attribute) {
            return isset($data[$attribute]) ? $data[$attribute] : null;
        }

        return $data;
    }

    public function createBrand(Shop $shop, Brand $brand)
    {
        try {
            $response = $this->getHttpClient()->post($this->getApiUrl('shop/brands', $shop), [
                'json' => [
                    'name' => $brand->name,
                    'external_id' => $brand->external_id,
                ]
            ]);

            if ($id = $this->getResponseValue($response, 'id')) {
                $brand->id = $id;
                return $brand;
            }
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }

        return false;
    }

    public function createMultipleBrands(Shop $shop, array $brands)
    {
        try {

            $data = array_map(function ($x) {
                /* @var $x Brand */
                return [
                    'name' => $x->name,
                    'external_id' => $x->external_id,
                ];
            }, $brands);

            $response = $this->getHttpClient()->post($this->getApiUrl('shop/brands/multiple', $shop), [
                'json' => $data,
            ]);

            $brands = ArrayHelper::index($brands, function ($x) {
                /* @var $x Brand */
                return $x->external_id;
            });

            $newData = ArrayHelper::index($this->getResponseValue($response), 'external_id');
            /* @var $brands Brand[] */
            $brands = array_intersect_key($brands, $newData);

            foreach ($brands as $external_id => $item) {
                $item->id = $newData[$external_id]['id'];
            }

            return $brands;
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }
    }

    public function updateBrand(Shop $shop, Brand $brand)
    {
        if (!$brand->id && !$brand->external_id) {
            throw new \Exception('Не указан id/external_id');
        }

        try {
            $response = $this->getHttpClient()->put($this->getApiUrl('shop/brands/' . ($brand->id ?: 'external/' . $brand->external_id), $shop), [
                'json' => [
                    'name' => $brand->name,
                    'external_id' => $brand->external_id,
                ]
            ]);

            return $brand;
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }
    }

    public function createCategory(Shop $shop, Category $category)
    {
        try {
            $response = $this->getHttpClient()->post($this->getApiUrl('shop/categories', $shop), [
                'json' => [
                    'name' => $category->name,
                    'parent_id' => $category->parent_id,
                    'external_id' => $category->external_id,
                ]
            ]);

            if ($id = $this->getResponseValue($response, 'id')) {
                $category->id = $id;
                return $category;
            }
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }

        return false;
    }

    /**
     * @param Shop $shop
     * @param array $categories
     * @return Category[]
     * @throws \Exception
     */
    public function createMultipleCategories(Shop $shop, array $categories)
    {
        try {

            $data = array_map(function ($x) {
                /* @var $x Category */
                return [
                    'name' => $x->name,
                    'parent_id' => $x->parent_id,
                    'external_id' => $x->external_id,
                ];
            }, $categories);

            $response = $this->getHttpClient()->post($this->getApiUrl('shop/categories/multiple', $shop), [
                'json' => $data,
            ]);

            $categories = ArrayHelper::index($categories, function ($x) {
                /* @var $x Category */
                return $x->external_id;
            });

            $newData = ArrayHelper::index($this->getResponseValue($response), 'external_id');
            /* @var $categories Category[] */
            $categories = array_intersect_key($categories, $newData);

            foreach ($categories as $external_id => $item) {
                $item->id = $newData[$external_id]['id'];
            }

            return $categories;
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }
    }

    /**
     * @param Shop $shop
     * @param array $categories
     * @return Category[]
     * @throws \Exception
     */
    public function updateMultipleCategories(Shop $shop, array $categories)
    {
        try {
            $data = array_map(function ($x) {
                /* @var $x Category */
                return [
                    'name' => $x->name,
                    'parent_id' => $x->parent_id,
                    'external_id' => $x->external_id,
                ];
            }, $categories);

            $response = $this->getHttpClient()->put($this->getApiUrl('shop/categories/multiple', $shop), [
                'json' => $data,
            ]);

            $categories = ArrayHelper::index($categories, function ($x) {
                /* @var $x Category */
                return $x->external_id;
            });

            $newData = ArrayHelper::index($this->getResponseValue($response), 'external_id');
            /* @var $categories Category[] */
            $categories = array_intersect_key($categories, $newData);

            return $categories;
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }
    }

    public function updateCategory(Shop $shop, Category $category)
    {
        if (!$category->id && !$category->external_id) {
            throw new \Exception('Не указан id/external_id');
        }

        try {
            $response = $this->getHttpClient()->put($this->getApiUrl('shop/categories/' . ($category->id ?: 'external/' . $category->external_id), $shop), [
                'json' => [
                    'name' => $category->name,
                    'parent_id' => $category->parent_id,
                    'external_id' => $category->external_id,
                ]
            ]);

            return $category;
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }
    }

    public function createAttribute(Shop $shop, Attribute $attribute)
    {
        try {
            $response = $this->getHttpClient()->post($this->getApiUrl('shop/attributes', $shop), [
                'json' => [
                    'name' => $attribute->name,
                    'external_id' => $attribute->external_id,
                    'unit' => $attribute->unit,
                ]
            ]);

            if ($id = $this->getResponseValue($response, 'id')) {
                $attribute->id = $id;
                return $attribute;
            }
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }

        return false;
    }

    public function createMultipleAttributes(Shop $shop, array $attributes)
    {
        try {

            $data = array_map(function ($x) {
                /* @var $x Attribute */
                return [
                    'name' => $x->name,
                    'external_id' => $x->external_id,
                    'unit' => $x->unit,
                ];
            }, $attributes);

            $response = $this->getHttpClient()->post($this->getApiUrl('shop/attributes/multiple', $shop), [
                'json' => $data,
            ]);

            $attributes = ArrayHelper::index($attributes, function ($x) {
                /* @var $x Attribute */
                return $x->external_id;
            });

            $newData = ArrayHelper::index($this->getResponseValue($response), 'external_id');
            /* @var $attributes Attribute[] */
            $attributes = array_intersect_key($attributes, $newData);

            foreach ($attributes as $external_id => $item) {
                $item->id = $newData[$external_id]['id'];
            }

            return $attributes;
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }
    }

    public function updateAttribute(Shop $shop, Attribute $attribute)
    {
        if (!$attribute->id && !$attribute->external_id) {
            throw new \Exception('Не указан id/external_id');
        }

        try {
            $response = $this->getHttpClient()->put($this->getApiUrl('shop/attributes/' . ($attribute->id ?: 'external/' . $attribute->external_id), $shop), [
                'json' => [
                    'name' => $attribute->name,
                    'external_id' => $attribute->external_id,
                ]
            ]);

            return $attribute;
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }
    }

    public function createAttributeValue(Shop $shop, AttributeValue $value)
    {
        try {
            $response = $this->getHttpClient()->post($this->getApiUrl('shop/attribute-values', $shop), [
                'json' => [
                    'value' => $value->value,
                    'attribute_id' => $value->attribute_id,
                    'external_id' => $value->external_id,
                ]
            ]);

            if ($id = $this->getResponseValue($response, 'id')) {
                $value->id = $id;
                return $value;
            }
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }

        return false;
    }

    public function createMultipleAttributeValues(Shop $shop, array $values)
    {
        try {

            $data = array_map(function ($x) {
                /* @var $x AttributeValue */
                return [
                    'value' => $x->value,
                    'attribute_id' => $x->attribute_id,
                    'external_id' => $x->external_id,
                ];
            }, $values);

            $response = $this->getHttpClient()->post($this->getApiUrl('shop/attribute-values/multiple', $shop), [
                'json' => $data,
            ]);

            $values = ArrayHelper::index($values, function ($x) {
                /* @var $x AttributeValue */
                return $x->external_id;
            });

            $newData = ArrayHelper::index($this->getResponseValue($response), 'external_id');
            /* @var $values AttributeValue[] */
            $values = array_intersect_key($values, $newData);

            foreach ($values as $external_id => $item) {
                $item->id = $newData[$external_id]['id'];
            }

            return $values;
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }
    }

    public function updateAttributeValue(Shop $shop, AttributeValue $value)
    {
        if (!$value->id && !$value->external_id) {
            throw new \Exception('Не указан id/external_id');
        }

        try {
            $response = $this->getHttpClient()->put($this->getApiUrl('shop/attributes/' . ($value->id ?: 'external/' . $value->external_id), $shop), [
                'json' => [
                    'value' => $value->value,
                    'attribute_id' => $value->attribute_id,
                    'external_id' => $value->external_id,
                ]
            ]);

            return $value;
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }
    }

    public function uploadProduct(Shop $shop, Product $product)
    {
        if (!$product->id && !$product->external_id) {
            throw new \Exception('Не указан id/external_id');
        }

        try {
            $response = $this->getHttpClient()->put($this->getApiUrl('shop/products/upload', $shop), [
                'json' => json_decode(json_encode($product, 320), true),
            ]);

            if ($id = $this->getResponseValue($response, 'id')) {
                $product->id = $id;
                return $product;
            }
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }

        return false;
    }

    public function createWorkProduct(Shop $shop, WorkProduct $product)
    {
        if (!$product->product->id) {
            throw new \Exception('Не указан id продукта');
        }

        try {
            $data = json_decode(json_encode($product, 320), true);
            $data['product_id'] = $product->product->id;

            $response = $this->getHttpClient()->post($this->getApiUrl('work/products', $shop), [
                'json' => $data,
            ]);

            if ($id = $this->getResponseValue($response, 'id')) {
                $product->id = $id;
                return $product;
            }
        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }

        return false;
    }

    public function getWorkProduct(Shop $shop, $work_product_id)
    {
        try {
            $response = $this->getHttpClient()->get($this->getApiUrl('work/products/' . $work_product_id, $shop, ['expand' => 'brand,category,eav,images']));

            $data = $this->getResponseValue($response);


            if ($brandData = $data['brand']) {
                $data['brand'] = new Brand([
                    'id' => $brandData['id'],
                    'external_id' => $brandData['external_id'],
                    'name' => $brandData['name'],
                ]);
            }

            if ($categoryData = $data['category']) {
                $data['category'] = new Brand([
                    'id' => $categoryData['id'],
                    'parent_id' => $categoryData['parent_id'],
                    'name' => $categoryData['name'],
                    'external_id' => $categoryData['external_id'],
                ]);
            }

            $eavData = ArrayHelper::getValue($data, 'eav');

            $eav = [];

            foreach ($eavData as $item) {
                $attributeData = $item['attribute'];
                $valueData = $item['value'];

                $eav[] = new ProductAttributeValue(
                    new Attribute([
                        'id' => $attributeData['id'],
                        'external_id' => $attributeData['external_id'],
                        'name' => $attributeData['name'],
                        'unit' => $attributeData['unit'],
                    ]),
                    new AttributeValue([
                        'id' => $valueData['id'],
                        'external_id' => $valueData['external_id'],
                        'attribute_id' => $valueData['attribute_id'],
                        'value' => $valueData['value'],
                    ])
                );
            }

            $data['eav'] = $eav;

            $images = [];
            $imagesData = ArrayHelper::getValue($data, 'images');

            foreach ($imagesData as $item) {
                $images[] = new ProductImage([
                    'id' => $item['id'],
                    'external_id' => $item['external_id'],
                    'product_id' => $item['product_id'],
                    'url' => $item['url'],
                    'title' => $item['title'],
                    'position' => $item['position'],
                ]);
            }

            $data['images'] = $images;

            $product = new WorkProduct(
                new Product([
                    'id' => $data['product_id'],
                ]),
                $data
            );

            return $product;

        } catch (ClientException $e) {
            throw new \Exception($e->getResponse()->getBody());
        }
    }
}
