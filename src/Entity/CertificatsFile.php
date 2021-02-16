<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Permet de pouvoir utiliser le form du certificats.
 */
class CertificatsFile
{
    /**
     * @ORM\Column(type="string")
     */
    private $fileName;

    /**
     * Get the value of fileName
     */ 
    public function getFileName()
    {
        return $this->fileName;
    }

    /**
     * Set the value of fileName
     *
     * @return  self
     */ 
    public function setFileName($fileName)
    {
        $this->fileName = $fileName;

        return $this;
    }
}