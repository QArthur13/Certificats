<?php


namespace App\Service;

/**
 * Class Useful
 * @package App\Service
 * Cette classe permet d'accéder à des outils plus facilement
 */
class Useful
{
    /**
     * @param $date
     * @return string
     */
    public static function conversionDate($date)
    {
        //On récupère le timestamp du fichier.
        $d = \DateTime::createFromFormat('ymdHisP', $date);
        $dateGMT = new \DateTime();
        $dateGMT->setTimestamp($d->getTimestamp());

        //Puis on le formate à une date MySQL.
        return $dateGMT->format('Y-m-d H:i:s');
    }

    /**
     * @param $data
     * Permet debugger plus facilement
     */
    public static function debug($data)
    {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }
}