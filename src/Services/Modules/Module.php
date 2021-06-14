<?php

namespace Hostville\Modullo\Services\Modules;


use Hostville\Modullo\Services\AbstractService;

class Module extends AbstractService
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
        return 'Module';
    }
}