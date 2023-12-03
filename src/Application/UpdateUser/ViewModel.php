<?php

declare(strict_types=1);

namespace Application\UpdateUser;

use Application\AbstractViewModel;

final class ViewModel extends AbstractViewModel
{
    /**
     * {@inheritdoc}
    */
    public static function createFromArray(?array $data = null): self
    {
        return new self();
    }
}
