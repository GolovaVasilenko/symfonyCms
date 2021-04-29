<?php


namespace App\Services\User;


use App\Entity\User;
use App\Repository\UserRepositoryInterface;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserService
{
    /**
     * @var UserRepositoryInterface
     */
    protected UserRepositoryInterface $repositpry;

    /**
     * @var UserPasswordEncoderInterface
     */
    protected UserPasswordEncoderInterface $encoder;

    public function  __construct(
        UserRepositoryInterface $repositpry,
        UserPasswordEncoderInterface $encoder
    )
    {
        $this->repositpry = $repositpry;
        $this->encoder = $encoder;
    }

    /**
     * @param User $user
     * @return object
     */
    public function handleCreate(User $user): object
    {
        $password = $this->encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $user->setRoles(['ROLE_ADMIN']);
        $this->repositpry->create($user);
        return $this;
    }

    /**
     * @param User $user
     * @return object
     */
    public function handleUpdate(User $user): object
    {
        $password = $this->encoder->encodePassword($user, $user->getPlainPassword());
        $user->setPassword($password);
        $this->repositpry->save($user);
        return $this;
    }
}