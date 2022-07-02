<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AssociationController extends AbstractController
{
    /**
     * @Route("/association", name="association")
     */
    public function index(): Response
    {
        return $this->render('association/association.html.twig', [
            'controller_name' => 'AssociationController',
        ]);
    }
}
