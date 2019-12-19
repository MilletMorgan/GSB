<?php

namespace App\Controller;

use App\Entity\FicheFrais;
use App\Entity\User;
use App\Form\FraisType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\User\UserInterface;

class FicheFraisController extends Controller
{
    /**
     * @Route("/fichefrais")
     */
    public function ficheFrais(Request $request)
    {
        $ficheFrais = new FicheFrais();
        $form = $this->createForm(FraisType::class, $ficheFrais);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            /** @var User $user */
            $user = $this->getUser();
            $ficheFrais->setUserId(intval($user->getId()));
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ficheFrais);
            $entityManager->flush();
            return $this->redirectToRoute('login');
        }
        return $this->render('html/fichefrais.html.twig', array('form' => $form->createView()));
    }
}