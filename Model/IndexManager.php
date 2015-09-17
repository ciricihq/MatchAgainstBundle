<?php

namespace Cirici\MatchAgainstBundle\Model;

class IndexManager
{
    private $em;

    public function setEm($em)
    {
        $this->em = $em;
    }
}
