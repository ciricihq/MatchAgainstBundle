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
        $gfield = 'get' . ucfirst($field);
        $content = $entity->{$gfield}();
        $index->setContent($content);

        if ($index->getContent()) {
            $this->em->persist($index);
            $this->em->flush();
        }
    }
}
