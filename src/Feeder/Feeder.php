<?php

namespace App\Feeder;


use App\Service\DateConvertorService;
use App\Entity\Order;
use App\Entity\Product;
use App\Entity\Supplier;
use Doctrine\ORM\EntityManagerInterface;

class Feeder
{
    /**
     * @var int
     */
    private $maxLines = 1000;

    /**
     * @var int
     */
    private $currentLine = 0;

    /** @var EntityManagerInterface */
    private $em;

    CONST SUPPLIER_TYPE = 'supplier';
    CONST PRODUCT_TYPE = 'product';
    CONST STOCK_TYPE = 'stock';


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    /**
     * @param String $pathFile
     * @param $type
     * @return bool
     */
    public function integrateProduct(String $pathFile)
    {
        $file = $this->openFile($pathFile);
        $this->currentLine = 0;

        // parse line by line
        while (($row = fgetcsv($file, $this->maxLines, ",")) !== FALSE) {
            
            // skip first line
            if ($this->currentLine === 0) {
                $this->currentLine++;
                continue;
            }

            // convert each line into array
            $row = explode(';', $row[0]);

            // save supplier and product
            if (!$supplier = $this->em->getRepository(Supplier::class)->findOneByName($row[2])) {

                $supplier = $this->setSupplier($row[2]);
                $this->em->persist($supplier);
                $this->em->flush();

                $item = $this->setProduct($row);
                $this->em->persist($item);
            }

            // only save products if supplier already exists
            else if (!$this->em->getRepository(Product::class)->findOneBy(['externalId' => $row[0], 'supplier' => $supplier] )) {
                $item = $this->setProduct($row);
                $this->em->persist($item);
            }
        }

        $this->em->flush();
        $this->em->clear();

        $this->currentLine++;

        return true;

    }

    /**
     * @param string $pathFile
     * @throws \Exception
     */
    public function integrateOrder(string $pathFile)
    {
        $file = $this->openFile($pathFile);
        $this->currentLine = 0;

        // parse line by line
        while (($row = fgetcsv($file, $this->maxLines, ",")) !== FALSE) {

            if ($this->currentLine === 0) {
                $this->currentLine++;
                continue;
            }

            // convert each line into array
            $row = explode(';', $row[0]);

            // seach the product linked to order, if there are no product, we skip the line
            if (!$product = $this->em->getRepository(Product::class)->findOneByExternalId($row[2])){
                $this->currentLine++;
                continue;
            }

            // if order doesn't already exist
            if (!$order = $this->em->getRepository(Order::class)->findOneBy(['externalId' => $row[0], 'product' => $product]) ) {
                // if it doesn't exist, we create the order
                $order = $this->setOrder($row);
                $this->em->persist($order);

                // we update the sold number of a product
                $product = $order->getProduct();
                $product->setSold(($product->getSold()) + $row[4]);

                // we update the rotation rate of the product = totalSold / (nbDays*7)
                $totalSold = $product->getSold();
            }

        }

        $this->em->flush();
    }

    private function openFile($filePath)
    {

        //todo : error management
        return fopen($filePath, "r");
    }

    /**
     * @param $data
     * @return Supplier
     */
    private function setSupplier($data)
    {

        $supplier = new Supplier();
        $supplier->setName($data);

        return $supplier;
    }

    /**
     * @param $data
     * @return Product
     */
    private function setProduct($data)
    {
        $product = new Product();

        $product->setExternalId($data[0]);
        $product->setName($data[1]);

        // get supplier id
        $supplier = $this->em->getRepository(Supplier::class)->findOneByName($data[2]);
        $product->setSupplier($supplier);

        //get stocks
        $product->setAquired($data[3]+$data[4]);

        return $product;
    }

    /**
     * @param $data
     * @return Order
     * @throws \Exception
     */
    private function setOrder($data)
    {
        $order = new Order();

        $order->setExternalId($data[0]);
        $product = $this->em->getRepository(Product::class)->findOneByExternalId($data[2]);
        $order->setProduct($product);
        $order->setQuantity($data[4]);

        // use date convertor for transforming input
        $dateConvertor = new DateConvertorService();
        $date =  $dateConvertor->convertDate($data[1]);
        $order->setDate($date);

        return $order;
    }

}
