<?php

namespace App\DataFixtures;

use App\Entity\User;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFixtures extends Fixture
{
    private $encoder;

    public function __construct(UserPasswordEncoderInterface $encoder)
    {
        $this->encoder = $encoder;
    }

    public function load(ObjectManager $manager)
    {
        $user = new User();

        $user
            ->setLastname('Quaranta')
            ->setFirstname('Arthur')
            ->setEmail('qarthur@youpi.fr')
            ->setPassword($this->encoder->encodePassword($user, 'Rt1!'))
        ;
        $manager->persist($user);

        $this->addReference('User', $user);

        $manager->flush();
    }
}
