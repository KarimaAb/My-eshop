<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    /**
     * @Route("voir-mon-panier", name="show_panier", methods={"GET"})
     */
    public function showPanier(SessionInterface $session): Response
    {
        return $this->render("panier/show_panier.html.twig");
    }
}