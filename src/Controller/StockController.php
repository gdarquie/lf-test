<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class StockController extends AbstractController
{
    /**
     * @Route("/stock", name="stock")
     */
    public function index()
    {
        //compute / update stock with a command
        // récupérer les stocks par produit (les grouper)
        // les ajouter aux ventes

        return $this->render('stock/index.html.twig', [
            'controller_name' => 'StockController',
        ]);
    }
}
