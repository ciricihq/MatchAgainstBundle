<?php

namespace Cirici\MatchAgainstBundle\Tests\Model;

use Liip\FunctionalTestBundle\Test\WebTestCase;
use Cirici\MaratoBundle\Entity\Organization;

class EntitySubscriberTest extends WebTestCase
{
    private $indexmanager;
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->indexmanager = static::$kernel->getContainer()
            ->get('cirici_match_against.text_manager')
        ;

        $this->em = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager')
        ;
    }

    public function testPostPersist()
    {
        $organization = new Organization();
        $organization->setExistingNifs(0);
        $organization->setExistingNames(0);
        $this->em->persist($organization);
        $this->em->flush();
    }
}
