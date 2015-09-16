<?php
namespace Cirici\MatchAgainstBundle\Tests\DataFixtures\ORM;

use Doctrine\Common\DataFixtures\FixtureInterface;
use Doctrine\Common\Persistence\ObjectManager;

use Cirici\MatchAgainstBundle\Entity\SearchTextIndex;

class LoadSearchTextIndexData implements FixtureInterface
{
    /**
     * {@inheritDoc}
     */
    public function load(ObjectManager $manager)
    {
        $this->addSearchTextIndex($manager, 1, 'Test\NamespaceBundle\Entity\TestEntity', 'name', 'Lorem Ipsum Amet Test');
        $this->addSearchTextIndex($manager, 1, 'Cirici\MaratoBundle\Entity\Organization', 'name', 'Lorem Ipsum Amet Test');
    }

    public function addSearchTextIndex($manager, $foreign, $model, $field, $content)
    {
        $textindex = new SearchTextIndex();
        $textindex->setForeignId($foreign);
        $textindex->setModel($model);
        $textindex->setField($field);
        $textindex->setContent($content);
        $manager->persist($textindex);
        $manager->flush();

    }
}