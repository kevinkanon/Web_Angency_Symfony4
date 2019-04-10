<?php
// Admin Controller for CRUD (create read update delate) operations of  houses. 

namespace App\Controller\Admin;

use App\Repository\PropertyRepository;
use App\Entity\Property;
use App\Form\PropertyType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\Common\Persistence\ObjectManager;

class AdminPropertyController extends AbstractController
{
    /**
     *
     * @var [PropertyRepository]
     */
    private $repository;

    /**
     * Entity manager who flush data operation in database
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
     * @Route("/admin", name="admin.property.index")
     * @return Response
     */
    public function index()
    {
        $properties = $this->repository->findAll();
        return $this->render('admin/property/index.html.twig', compact('properties') );
    }

    /**
     * Create a new property & persist it before flush by the entity Manager to the database
     *
     * @Route("/admin/property/create", name="admin.property.new")
     * @param Request $request 
     * @return Response
     */
    public function new(Request $request)
    {
        $property = new Property();
        $form = $this->createForm(PropertyType::class, $property); // createForm(formType, data)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->persist($property);
            $this->entityManager->flush();
            $this->addFlash('success', 'Bien Crée avec succès!');
            return $this->redirectToRoute('admin.property.index'); 
        }

        return $this->render('admin/property/new.html.twig', ['property' => $property, 'form' => $form->createView()]);
    }

    /**
     * display the property get by params converter to edit it before flush it to database
     *
     * @Route("/admin/property/{id}", name="admin.property.edit", methods="GET|POST")
     * @param Property $property 
     * @param Request $request 
     * @return Response
     */
    public function edit(Property $property, Request $request)
    {
        $form = $this->createForm(PropertyType::class, $property); // createForm(formType, data)
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid())
        {
            $this->entityManager->flush();
            $this->addFlash('success', 'Bien modifié avec succès!');
            return $this->redirectToRoute('admin.property.index'); 
        }

        return $this->render('admin/property/edit.html.twig', ['property' => $property, 'form' => $form->createView()]);
    }

    /**
     * Delete one property from database with csrf token protection params add on our form | not a  form create by symfony to delete
     * 
     * @Route("/admin/property/{id}", name="admin.property.delete", methods="DELETE")
     * @param Property $property
     * @return Response
     */
    public function delete(Property $property, Request $request)
    {
        $submittedToken = $request->request->get('_token');

        if ($this->isCsrfTokenValid('delete' . $property->getId(), $submittedToken)) {
            $this->entityManager->remove($property);
            $this->entityManager->flush();
            $this->addFlash('success', 'Bien supprimé avec succès!');
        }
       
        return $this->redirectToRoute('admin.property.index'); 
    }

}
