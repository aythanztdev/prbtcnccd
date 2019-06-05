<?php

namespace App\Controller;

use App\Entity\MediaObject;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

final class ShowMediaObjectAction
{
    private $params;

    function __construct(ParameterBagInterface $params)
    {
        $this->params = $params;
    }

    public function __invoke(MediaObject $data): BinaryFileResponse
    {
        $mediaPath = sprintf('%s/media/%s', $this->params->get('webDir'), $data->getFilePath());
        $file = new BinaryFileResponse($mediaPath);

        return $file;
    }
}