<?php

namespace App\DataFixtures;

use App\Entity\Information;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;

class InformationFixtures extends Fixture implements DependentFixtureInterface
{
    public function load(ObjectManager $manager)
    {
        $information = new Information();
        $valide = new \DateTime('2021-03-15 08:30:00');
        $expire = new \DateTime('2021-04-01 17:45:00');

        $information
            ->setSociety('Arthur&Co')
            ->setDomain('*.arthurco.com')
            ->setProviderSociety('Eset')
            ->setProviderDomain('*.Eset.com')
            ->setValideDate($valide)
            ->setExpireDate($expire)
            ->setUser($this->getReference('User'))
        ;

        $manager->persist($information);

        $manager->flush();
    }

    public function getDependencies()
    {
        return [

            UserFixtures::class
        ];
    }
}
