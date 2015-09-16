<?php

namespace Cirici\MatchAgainstBundle\Model;

class TextSearchManager
{
    private $em;

    public function setEm($em)
    {
        $this->em = $em;
    }

    public function findSimilarsByScore($text, $entity_class, $field_name, $score)
    {
        $qbuilder = $this->em->createQueryBuilder("o");
        $qbuilder
            ->select('sti.foreignId')
            ->from('Cirici\MatchAgainstBundle\Entity\SearchTextIndex', 'sti')
            ->where('sti.model = :entityClass')
            ->andWhere('sti.field = :fieldName')
            // ->andWhere("MATCH_AGAINST(sti.content, :text 'IN NATURAL LANGUAGE MODE') > :score")
            ->andWhere("MATCH_AGAINST(sti.content, :text 'IN BOOLEAN MODE') > :score")
            ->setParameter('entityClass', $entity_class)
            ->setParameter('fieldName', $field_name)
            ->setParameter('text', $text)
            ->setParameter('score', $score)
        ;

        $query = $qbuilder->getQuery();
        return $query->getResult();
    }
}
