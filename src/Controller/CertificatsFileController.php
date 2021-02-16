<?php

namespace App\Controller;

use App\Entity\CertificatsFile;
use App\Form\CertificatsFileType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CertificatsFileController extends AbstractController
{
    /**
     * @Route("/user/user", name="app_user_form")
     */
    public function form(Request $request, SluggerInterface $slugger)
    {

        $certificats = new CertificatsFile();
        $form = $this->createForm(CertificatsFileType::class, $certificats);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            
            /** @var UploadedFile $certificatsFile */
            $certificatsFile = $form->get('certificats')->getData();
            $data = openssl_x509_parse($certificatsFile->getContent());

            return $this->redirectToRoute('app_user_list');
        }

        return $this->render('user/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
