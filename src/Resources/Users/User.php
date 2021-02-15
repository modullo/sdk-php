<?php

namespace Hostville\Modulo\Resources\Users;


use Hostville\Modulo\Resources\AbstractResource;

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