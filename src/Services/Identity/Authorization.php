<?php

namespace Hostville\Modullo\Services\Identity;


use Hostville\Modullo\Services\AbstractService;

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