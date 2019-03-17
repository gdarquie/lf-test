<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Supplier;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class MonitorController extends AbstractController
{
    /**
     * @Route("/monitor", name="monitor")
     */
    public function index()
    {
        $suppliersNb = $this->getDoctrine()->getRepository(Supplier::class)->countAll();
        $productsNb = $this->getDoctrine()->getRepository(Product::class)->countAll();
        $ordersNb = $this->getDoctrine()->getRepository(Order::class)->countAll();
        $products = $this->getDoctrine()->getRepository(Product::class)->findAll();
        $suppliers = $this->getDoctrine()->getRepository(Supplier::class)->findAll();

        return $this->render('dashboard.html.twig', array(
            'suppliersNb' => $suppliersNb,
            'productsNb' => $productsNb,
            'ordersNb' => $ordersNb,
            'products' => $products,
            'suppliers' => $suppliers
        ));
    }
}
