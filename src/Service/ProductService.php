<?php

namespace App\Service;

use App\Entity\Product;
use App\Entity\MediaObject;
use Symfony\Component\HttpKernel\Exception\ConflictHttpException;

class ProductService 
{
    public function validateData(Product $product)
    {
        foreach ($product->getImages() as $image) {
            if ($image->getStatus() === MediaObject::STATUS_ASSIGNED)
                throw new ConflictHttpException(sprintf('The image with id: %s belong to other resource already', $image->getId()));
        }
    }

    public function prepareData(Product $product)
    {
        $price = $product->getPrice();
        $taxValue = $product->getTax()->getValue();
        $priceWithTax = $this->calculatePriceWithTax($price, $taxValue);
        $product->setPriceWithTax($priceWithTax);

        $images = $product->getImages();
        $this->setImagesWithStatusAssigned($images);
    }

    private function calculatePriceWithTax(float $price, float $taxValue): float
    {
        $priceWithTax = $price*($taxValue/100)+$price;
        
        return $priceWithTax;
    }

    private function setImagesWithStatusAssigned($images)
    {
        foreach ($images as $image) {
            $image->setStatus(MediaObject::STATUS_ASSIGNED);
        }
    }
}