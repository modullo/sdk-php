<?php

namespace Hostville\Modullo\Services\Lessons;


use Hostville\Modullo\Services\AbstractService;

class Lesson extends AbstractService
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
        return 'Lesson';
    }
}