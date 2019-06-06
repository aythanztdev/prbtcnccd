<?php

namespace App\Tests;

use App\Service\ProductService;
use PHPUnit\Framework\TestCase;

class CalculatePriceWithTaxTest extends TestCase
{
    /** @test */
    public function calculatePriceWithTax(): void
    {
        $productService = new ProductService();
        $result = $productService->calculatePriceWithTax(100, 2);

        $this->assertEquals(102, $result);
    }
}