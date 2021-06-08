<?php

namespace Hostville\Modullo\Services\Programs;


use Hostville\Modullo\Services\AbstractService;

class Program extends AbstractService
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
        return 'Program';
    }
}