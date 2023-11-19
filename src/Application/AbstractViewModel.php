<?php

declare(strict_types=1);

namespace Application;

abstract class AbstractViewModel implements ViewModelInterface
{
    /**
     * @param mixed[]|null $data
     */
    abstract public static function createFromArray(null|array $data = null): self;
}
