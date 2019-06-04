<?php

namespace App\Service;

use App\Entity\Product;

class ProductService 
{
    public function prepareData(Product $product)
    {
        $price = $product->getPrice();
        $taxValue = $product->getTax()->getValue();
        $priceWithTax = $this->calculatePriceWithTax($price, $taxValue);

        $product->setPriceWithTax($priceWithTax);
    }

    private function calculatePriceWithTax($price, $taxValue)
    {
        $priceWithTax = $price*($taxValue/100)+$price;
        
        return $priceWithTax;
    }
}