<?php

declare(strict_types=1);

namespace Application\DeleteUser;

use Application\InputModelInterface;
use Application\ServiceInterface;
use Application\ViewModelInterface;
use Domain\Interfaces\UserRepositoryInterface;

final class DeleteUser implements ServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    /**
     * {@inheritDoc}
     */
    public function handle(InputModelInterface $input): ViewModelInterface
    {
        /** @var InputModel $input */
        $this->repository->remove($input->getId());

        return ViewModel::createFromArray([]);
    }
}
