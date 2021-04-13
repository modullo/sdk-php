<?php

namespace Hostville\Modullo\Resources;


class Tenant extends AbstractResource
{

    /**
     * Returns the name of the resource.
     *
     * @return string
     */
    function getName(): string
    {
        return 'Tenant';
    }
}