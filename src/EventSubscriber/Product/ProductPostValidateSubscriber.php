<?php

namespace App\EventSubscriber\Product;

use App\Entity\Product;
use App\Service\ProductService;
use ApiPlatform\Core\EventListener\EventPriorities;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\HttpKernel\Event\GetResponseForControllerResultEvent;

final class ProductPostValidateSubscriber implements EventSubscriberInterface
{
    private $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::VIEW => ['prepareProductData', EventPriorities::POST_VALIDATE],
        ];
    }

    public function prepareProductData(GetResponseForControllerResultEvent $event)
    {
        $product = $event->getControllerResult();
        $method = $event->getRequest()->getMethod();

        if (!$product instanceof Product || Request::METHOD_POST !== $method)
            return;

        $this->productService->prepareData($product);
    }
}