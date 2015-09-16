<?php

namespace Cirici\MatchAgainstBundle\Tests\Model;

use Liip\FunctionalTestBundle\Test\WebTestCase;

use Cirici\MatchAgainstBundle\Model\TextSearchManager;

class TextSearchManagerTest extends WebTestCase
{
    private $textsearchmanager;
    private $em;

    /**
     * {@inheritDoc}
     */
    public function setUp()
    {
        static::$kernel = static::createKernel();
        static::$kernel->boot();

        $this->textsearchmanager = static::$kernel->getContainer()
            ->get('cirici_match_against.text_manager')
        ;

        $this->em = static::$kernel->getContainer()
            ->get('doctrine.orm.entity_manager')
        ;

        $this->loadFixtures(array(
            'Cirici\MatchAgainstBundle\Tests\DataFixtures\ORM\LoadSearchTextIndexData'
        ));
    }

    public function testfindSimilarsByScore()
    {
        // Those tests only will work with mysql database
        if ($this->em->getConnection()->getDriver()->getName() === 'pdo_mysql') {
            $ids = $this->textsearchmanager->findSimilarsByScore('lorem', 'Test\NamespaceBundle\Entity\TestEntity', 'name', 0.8);

            $this->assertTrue(is_array($ids));

            $this->assertGreaterThan(0, count($ids));
        }
    }
}
