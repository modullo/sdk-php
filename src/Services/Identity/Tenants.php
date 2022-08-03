<?php

namespace Hostville\Modullo\Services\Identity;


use Hostville\Modullo\Services\AbstractService;

class Tenants extends AbstractService
{
    /**
     * @inheritdoc
     */
    public function requiresAuthorization(): bool
    {
        return true;
    }

    /**
     * Returns the name of the service.
     *
     * @return string
     */
    function getName(): string
    {
        return 'Tenants';
    }
}