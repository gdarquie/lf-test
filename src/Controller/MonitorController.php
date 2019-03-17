<?php

namespace App\Controller;

use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Supplier;
use Pagerfanta\Adapter\ArrayAdapter;
use Pagerfanta\Adapter\DoctrineORMAdapter;
use Pagerfanta\Pagerfanta;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class MonitorController extends AbstractController
{
    /**
     * @Route("/monitor", name="monitor")
     */
    public function index(Request $request)
    {
        // some general stats
        $suppliersNb = $this->getDoctrine()->getRepository(Supplier::class)->countAll();
        $productsNb = $this->getDoctrine()->getRepository(Product::class)->countAll();
        $ordersNb = $this->getDoctrine()->getRepository(Order::class)->countAll();

        // list of items : products, suppliers and orders

        // todo : finish pagination part + refacto
        // pagination
        $productPage = $request->query->get('product-page', 1);
        $supplierPage = $request->query->get('supplier-page', 1);
        $orderPage = $request->query->get('order-page', 1);

        // products
        // todo: add a real logic for getting products need to be ordered, for the moment, it is only filter with twig  : if we have more than 100 products, every products won't be filter : add a query for selecting product need to be ordered + pagination
        $qb = $this->getDoctrine()
            ->getRepository(Product::class)
            ->findAllQueryBuilder();
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(100);
        $pagerfanta->setCurrentPage($productPage);
        $products = [];

        foreach ($pagerfanta->getCurrentPageResults() as $result) {
            $products[] = $result;
        }

        //suppliers
        $qb = $this->getDoctrine()
            ->getRepository(Supplier::class)
            ->findAllQueryBuilder();
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(25);
        $pagerfanta->setCurrentPage($supplierPage);
        $suppliers = [];

        foreach ($pagerfanta->getCurrentPageResults() as $result) {
            $suppliers[] = $result;
        }

        // orders
        $qb = $this->getDoctrine()
            ->getRepository(Order::class)
            ->findAllQueryBuilder();
        $adapter = new DoctrineORMAdapter($qb);
        $pagerfanta = new Pagerfanta($adapter);
        $pagerfanta->setMaxPerPage(25);
        $pagerfanta->setCurrentPage($orderPage);
        $orders = [];

        foreach ($pagerfanta->getCurrentPageResults() as $result) {
            $orders[] = $result;
        }

        return $this->render('dashboard.html.twig', array(
            'suppliersNb' => $suppliersNb,
            'productsNb' => $productsNb,
            'ordersNb' => $ordersNb,
            'products' => $products,
            'suppliers' => $suppliers,
            'orders' => $orders
        ));
    }
}
