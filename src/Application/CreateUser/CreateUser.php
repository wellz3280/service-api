<?php

declare(strict_types=1);

namespace Application\CreateUser;

use Application\InputModelInterface;
use Application\ServiceInterface;
use Application\ViewModelInterface;
use Domain\Entities\User;
use Domain\Interfaces\UserRepositoryInterface;

final class CreateUser implements ServiceInterface
{
    public function __construct(
        private UserRepositoryInterface $repository
    ) {
    }

    /**
     * @param InputModel $input
     * @return ViewModel
     */
    public function handle(InputModelInterface $input): ViewModelInterface
    {
        $user = User::createFromArray([
            'name'  => $input->getName(),
            'email' => $input->getEmail(),
        ]);

        $this->repository->save($user);

        return ViewModel::createFromArray([
            'name'       => $user->getName(),
            'email'      => $user->getEmail()->value(),
            'created_at' => $user->getCreatedAt(),
        ]);
    }
}