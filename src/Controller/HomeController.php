<?php

namespace App\Controller;

use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Common\Persistence\ObjectManager;
use Twig\Environment;

class HomeController extends AbstractController
{
              
     /**
     * display all houses
     *
     * @Route("/", name="home")
     * @return Response
     */
    public function index(PropertyRepository $repository): Response 
    {
        $properties = $repository->findLatest();
        return $this->render('pages/home.html.twig', ['properties' => $properties]);
    }

}
