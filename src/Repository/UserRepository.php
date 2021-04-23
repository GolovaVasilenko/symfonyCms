<?php

namespace App\Repository;

use App\Entity\User;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Security\Core\Exception\UnsupportedUserException;
use Symfony\Component\Security\Core\User\PasswordUpgraderInterface;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @method User|null find($id, $lockMode = null, $lockVersion = null)
 * @method User|null findOneBy(array $criteria, array $orderBy = null)
 * @method User[]    findAll()
 * @method User[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class UserRepository
    extends ServiceEntityRepository
    implements PasswordUpgraderInterface, UserRepositoryInterface
{
    /**
     * @var EntityManagerInterface
     */
    protected EntityManagerInterface $em;

    public function __construct(ManagerRegistry $registry, EntityManagerInterface $entityManager)
    {
        parent::__construct($registry, User::class);
        $this->em = $entityManager;
    }

    /**
     * Used to upgrade (rehash) the user's password automatically over time.
     */
    public function upgradePassword(UserInterface $user, string $newEncodedPassword): void
    {
        if (!$user instanceof User) {
            throw new UnsupportedUserException(sprintf('Instances of "%s" are not supported.', \get_class($user)));
        }

        $user->setPassword($newEncodedPassword);
        $this->_em->persist($user);
        $this->_em->flush();
    }

    public function getOne($userId): object
    {
        return parent::find($userId);
    }

    public function getAll(): array
    {
        return parent::findAll();
    }

    /**
     * @param User $user
     * @return mixed|void
     */
    public function create(User $user)
    {
        $this->em->persist($user);
        $this->em->flush();
    }

    /**
     * @param User $user
     * @return mixed|void
     */
    public function save(User $user)
    {
        $this->em->flush();
    }
}
