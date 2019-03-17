<?php

namespace App\Controller;

use App\Feeder\Feeder;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Finder\Finder;
use Symfony\Component\Routing\Annotation\Route;

class FeederController extends AbstractController
{
    /**
     * @Route("/feeder", name="feeder")
     */
    public function integrate($file = '')
    {
        $finder = new Finder();
        $finder->files()->in('../data');

        // get all files
        $files = [];
        foreach ($finder as $file) {
            array_push($files, $file->getRealPath());
        }

        // integrate supplier file with feeder
        $feeder = new Feeder($this->getDoctrine()->getManager());
        $feeder->integrateProduct($files[1]);
        $feeder->integrateOrder($files[0]);


        return $this->json([
            'message' => 'Welcome to your new controller!',
            'path' => 'src/Controller/FeederController.php',
        ]);
    }

}


