<?php

declare(strict_types=1);

namespace Application\GetUserById;

use Application\InputModelInterface;
use Application\ServiceInterface;
use Application\ViewModelInterface;
use Domain\Interfaces\UserRepositoryInterface;

final class GetUserById implements ServiceInterface
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

        return ViewModel::createFromArray([
            'id'            => $user->getId(),
            'name'          => $user->getName(),
            'email'         => $user->getEmail()->value(),
            'created_at'    => $user->getCreatedAt(),
            'updated_at'    => $user->getUpdatedAt(),
        ]);
    }
}
