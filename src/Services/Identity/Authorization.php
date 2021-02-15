<?php

namespace Hostville\Modulo\Services\Identity;


use Hostville\Modulo\Services\AbstractService;

class Authorization extends AbstractService
{
    
    /**
     * Returns the name of the resource.
     *
     * @return string
     */
    function getName(): string
    {
        return 'Authorization';
    }
}