<?php

namespace LOCKSSOMatic\CRUDBundle\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\AbstractFixture;
use Doctrine\Common\DataFixtures\OrderedFixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;
use LOCKSSOMatic\CRUDBundle\Entity\Deposits;

class LoadDepositsData extends AbstractFixture implements OrderedFixtureInterface
{
    
    public function getOrder()
    {
        return 3; // after plns and plugins
    }

    public function load(ObjectManager $manager)
    {
        $object = new Deposits();
        $object->setUuid('123456-1234-12345678-123456');
        $object->setTitle('First deposit');
        $object->setSummary('An example deposit for testing purposes.');
        $object->setContentProvider($this->getReference('cp-1'));
        
        $manager->persist($object);
        $manager->flush();
        $this->setReference('deposit-1', $object);
    }
}
