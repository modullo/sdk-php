<?php

namespace Hostville\Modullo\Resources\Users;


use Hostville\Modullo\Resources\AbstractResource;

class User extends AbstractResource
{

    /**
     * Returns the name of the resource.
     *
     * @return string
     */
    function getName(): string
    {
        return 'User';
    }
}