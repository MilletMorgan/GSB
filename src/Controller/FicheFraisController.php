<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use App\Form\FicheFraisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class FicheFraisController extends Controller
{
    /**
     * @Route("/number")
     */
    public function numberAction()
    {
        $number = rand(0, 100);
        return new Response(
            '<html><body>Lucky number: ' . $number . '</body></html>'
        );
    }

    /**
     * @Route("/fichefrais")
     */
    public function ficheFrais(Request $request)
    {
        $ficheFrais = new FicheFrais();
        $form = $this->createForm(FicheFraisType::class, $ficheFrais);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $userId = $this->getUser();
            $ficheFrais->setUser(intval($userId->userId));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ficheFrais);
            $entityManager->flush();
            return $this->redirectToRoute('login');
        }
        return $this->render('html/fichefrais.html.twig', array('form' => $form->createView()));
    }
}