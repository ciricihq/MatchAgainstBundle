MatchAgainstBundle
==================

Based on https://gist.github.com/ZeBigDuck/1234419

Usage
-----

You must load the bundle provided config.yml in order to have the
`MATCH_AGAINST` MySQL sentence

```yml
imports:
    - { resource: ../../src/Cirici/MatchAgainstBundle/Resources/config/config.yml }
```

Make a query:

```php
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
```
