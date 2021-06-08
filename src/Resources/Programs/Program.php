<?php

namespace Hostville\Modullo\Resources\Programs;


use Hostville\Modullo\Resources\AbstractResource;

class Program extends AbstractResource
{

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