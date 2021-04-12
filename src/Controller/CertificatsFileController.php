<?php

namespace App\Controller;

use App\Entity\Certificats;
use App\Entity\Information;
use App\Form\CertificatsFileType;
use App\Repository\InformationRepository;
use DateTime;
use Doctrine\Persistence\ObjectManager;
use phpDocumentor\Reflection\PseudoTypes\True_;
use phpDocumentor\Reflection\Types\Self_;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Validator\Constraints\Date;

class CertificatsFileController extends AbstractController
{

    /**
     * Permet de convertir la date qu'on récupère d'un certificats
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
     * @Route("/user/list", name="app_user_list")
     */
    public function list(InformationRepository $informationRepository)
    {
        return $this->render('user/list.html.twig', ['lists' => $informationRepository->findAll()]);
    }

    /**
     * @Route("/user/form", name="app_user_form")
     */
    public function form(Request $request, SluggerInterface $slugger)
    {

        $certificats = new Certificats();
        $form = $this->createForm(CertificatsFileType::class, $certificats);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var UploadedFile $certificatsFile */
            $certificatsFile = $form->get('certificats')->getData();
            $data = openssl_x509_parse(openssl_x509_read($certificatsFile->getContent()));
            $information = new Information();

            $valideDate = DateTime::createFromFormat('ymdHisP', $data['validFrom']);
            $valideGMT = new DateTime();
            $valideGMT->setTimestamp($valideDate->getTimestamp());
            $valideGMT->format('Y-m-d H:i:s');

            $valideExpire = DateTime::createFromFormat('ymdHisP', $data['validTo']);
            $expireGMT = new DateTime();
            $expireGMT->setTimestamp($expireGMT->getTimestamp());
            $expireGMT->format('Y-m-d H:i:s');

            $information
                ->setSociety($data['subject']['O'])
                ->setDomain($data['subject']['CN'])
                ->setProviderSociety($data['issuer']['O'])
                ->setProviderDomain($data['issuer']['CN'])
                ->setValideDate($valideGMT)
                ->setExpireDate($expireGMT)
            ;

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($information);
            $entityManager->flush();

            return $this->redirectToRoute('app_user_list');
        }

        return $this->render('user/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
