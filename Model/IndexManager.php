<?php

namespace Cirici\MatchAgainstBundle\Model;

use Cirici\MatchAgainstBundle\Entity\SearchTextIndex;

class IndexManager
{
    private $em;

    public function setEm($em)
    {
        $this->em = $em;
    }

    public function addIndex($entity, $field)
    {
        $index = new SearchTextIndex();
        $index->setForeignId($entity->getId());
        $index->setModel(get_class($entity));
        $index->setField($field);
        $index->setContent($this->getSelectedContent($entity, $field));

        if ($index->getContent()) {
            $this->em->persist($index);
            $this->em->flush();
        }
    }

    public function updateIndex($entity)
    {
        $index = $this->em
            ->getRepository('Cirici\MatchAgainstBundle\Entity\SearchTextIndex')
            ->findOneBy(array('foreignId' => $entity->getId()))
        ;
        $index->setContent($this->getSelectedContent($entity, $index->getField()));
        $this->em->persist($index);
        $this->em->flush();
    }

    public function removeIndex($entity)
    {
        $index = $this->em
            ->getRepository('Cirici\MatchAgainstBundle\Entity\SearchTextIndex')
            ->findOneBy(array('foreignId' => $entity->getId()))
        ;
        $this->em->remove($index);
        $this->em->flush();
    }

    private function getSelectedContent($entity, $field)
    {
        $gfield = 'get' . ucfirst($field);
        $content = $entity->{$gfield}();

        return $content;
    }
}
