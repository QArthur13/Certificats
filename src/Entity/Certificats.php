<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Permet de pouvoir utiliser le form du certificats.
 */
class Certificats
{
    /**
     * @ORM\Column(type="string")
     */
    private $certificatFile;

    /**
     * Get the value of fileName
     */ 
    public function getCertificatFile()
    {
        return $this->certificatFile;
    }

    /**
     * Set the value of fileName
     *
     * @return  self
     */ 
    public function setCertificatFile($certificatFile)
    {
        $this->certificatFile = $certificatFile;

        return $this;
    }
}