<?php

namespace Hostville\Modullo\Services\Identity;


use Hostville\modullo\Services\AbstractService;

class Tenant extends AbstractService
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
        return 'Tenant';
    }
}