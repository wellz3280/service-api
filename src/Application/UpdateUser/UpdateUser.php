<?php

declare(strict_types=1);

namespace Application\UpdateUser;

use Application\InputModelInterface;
use Application\ServiceInterface;
use Application\ViewModelInterface;
use Domain\Interfaces\UserRepositoryInterface;

final class UpdateUser implements ServiceInterface
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
        $user = $this->repository->findById($input->getId());
        $user->withName($input->getName());

        $this->repository->update($user);

        return ViewModel::createFromArray([]);
    }
}
