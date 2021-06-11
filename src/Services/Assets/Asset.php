<?php

namespace Hostville\Modullo\Services\Assets;


use Hostville\Modullo\Services\AbstractService;

class Asset extends AbstractService
{
    /**
     * @inheritdoc
     */
    public function requiresAuthorization(): bool
    {
        return true;
    }

    /**
     * Returns the name of the resource.
     *
     * @return string
     */
    function getName(): string
    {
        return 'Asset';
    }
}