<?php

namespace App\Controller;

use App\Entity\Certificats;
use App\Entity\Information;
use App\Form\CertificatsFileType;
use Doctrine\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CertificatsFileController extends AbstractController
{
    /**
     * @Route("/user/list", name="app_user_list")
     */
    public function list()
    {
        $data = new Information();
        $lists = array(
            'id' => $data->getId(), 'Societe' => $data->getSociety(), 'Domaine' => $data->getDomain(),
             'SocieteFournisseur' => $data->getProviderSociety(), 'DomaineFournisseur' => $data->getProviderDomain(),
              'DateValidation' => $data->getValideDate(), 'DateExpiration' => $data->getExpireDate()
        );

        return $this->render('user/list.html.twig', ['lists' => $lists]);
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
            $data = openssl_x509_parse($certificatsFile->getContent());

            $data = new Information();

            $data
                ->setSociety($$data->getSociety())
                ->setDomain($data->getDomain())
                ->setProviderSociety($data->getProviderSociety())
                ->setProviderDomain($data->getProviderDomain())
                ->setValideDate($data->getValideDate())
                ->setExpireDate($data->getValideDate())
            ;

            $manager = new ObjectManager();
            $manager->persist($data);
            $manager->flush();

            return $this->redirectToRoute('app_user_list');
        }

        return $this->render('user/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
