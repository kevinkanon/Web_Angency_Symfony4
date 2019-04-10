<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;

class PropertyController extends AbstractController
{
    /**
     *
     * @var PropertyRepository
     */
    private $repository;

    /**
     *represent the ObjectManager
     * @var entityManager
     */
    private $entityManager;

    public function __construct(PropertyRepository $repository, ObjectManager $entityManager) 
    { 
        $this->repository = $repository; 
        $this->entityManager = $entityManager; 
    }

    /**
     * display all houses
     *
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(PaginatorInterface $paginator, Request $request): Response
    {
            $properties = $paginator->paginate(
            $this->repository->findAllVisibleQuery(), /* query NOT result */
            $request->query->getInt('page', 1), /*page number*/
            12 /*limit per page*/
        );

        return $this->render('property/index.html.twig', [
            'current_menu' => 'properties',
            'properties' => $properties
            ]);
    }

    /**
     * 301 permanent redirect if the slug is not correct in th url 
     * 
     * @Route("/biens/{slug}-{id}", name="property.show", requirements={"slug"="[a-z0-9\-]*"})
     * @return Response
     */
    public function show(Property $property, string $slug): Response 
    {
        if($property->getSlug() !== $slug)
        { 
            return $this->redirectToRoute('property.show', ['id' => $property->getId(), 'slug' => $property->getSlug()], 301); 
        }

        return $this->render('property/show.html.twig', ['property'  =>  $property, 'current_menu' => 'properties']);
    }
}