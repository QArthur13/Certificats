<?php

namespace App\Controller;

use App\Entity\Certificats;
use App\Entity\Information;
use App\Form\CertificatsFileType;
use App\Repository\InformationRepository;
use App\Service\Useful;
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
     * @Route("/user/list", name="app_user_list")
     *
     * @param InformationRepository $informationRepository
     * Ceci nous permet de voir la liste de tout les certificats
     * @return Response
     * @throws \Exception
     */
    public function list(InformationRepository $informationRepository)
    {
        $today = new DateTime('now', new \DateTimeZone('Europe/Paris'));
        //($today);
        $test = DateTime::createFromFormat('Y-m-d H:i:s', '2021-03-10 15:04:03');
        $expireDate = $informationRepository->nearExpireV2($today);
        $expiration = $expireDate;

        foreach ($expiration as $index => $expire){

            if ($expiration[$index]['expiration'] = $expire['expiration'] > 0 && $expiration[$index]['expiration'] = $expire['expiration'] < 6){

                $this->addFlash('notice', 'Le certifcat N°'.$expire['id'].' va expirer dans '.$expire['expiration'].' jours!');
            }
        }

        return $this->render('user/list.html.twig', [
            
            'lists' => $informationRepository->findAll(),
            'today' => $today,
            'expireDate' => $expireDate,
            ]);
    }

    /**
     * @Route("/user/form", name="app_user_form")
     * @param Request $request
     * @param SluggerInterface $slugger
     * Permet d'ajouter un certificats
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
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
            $expireGMT->setTimestamp($valideExpire->getTimestamp());
            $expireGMT->format('Y-m-d H:i:s');

            $information
                ->setSociety($data['subject']['O'])
                ->setDomain($data['subject']['CN'])
                ->setProviderSociety($data['issuer']['O'])
                ->setProviderDomain($data['issuer']['CN'])
                ->setValideDate($valideGMT)
                ->setExpireDate($expireGMT)
                ->setUser($this->getUser())
            ;

            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($information);
            $entityManager->flush();

            $this->addFlash('success', 'Et Hop! Un certificats ajouter! ^^');

            return $this->redirectToRoute('app_user_list');
        }

        return $this->render('user/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
