<?php

namespace Hostville\Modullo\Services\Home;


use Hostville\Modullo\Services\AbstractService;

class Home extends AbstractService
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
        return 'Home';
    }
}