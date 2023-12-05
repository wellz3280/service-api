<?php

declare(strict_types=1);

namespace Application\DeleteUser;

use Application\AbstractViewModel;

final class ViewModel extends AbstractViewModel
{
    public static function createFromArray(?array $data = null): self
    {
        return new self();
    }
}
