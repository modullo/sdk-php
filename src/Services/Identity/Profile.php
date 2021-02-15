<?php

namespace Hostville\Modulo\Services\Identity;


use Hostville\Modulo\Services\AbstractService;

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