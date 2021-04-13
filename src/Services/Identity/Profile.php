<?php

namespace Hostville\Modullo\Services\Identity;


use Hostville\Modullo\Services\AbstractService;

class Profile extends AbstractService
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
        return 'Profile';
    }
}