<?php
namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Repository\RestaurantRepository;
use App\Entity\Restaurant;
use App\Form\RestaurantType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Doctrine\ORM\EntityRepository;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

class AdminRestaurantController extends AbstractController
{
    /**
     * @var RestaurantRepository
     */
    private $repository;

    /**
     * @var ObjectManager
     */ 

    private $em;

    public function __construct(RestaurantRepository $repository, ObjectManager $em)
    {
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/admin-restaurant", name="admin.restaurant.index")
     * @return \Symfony\Composant\HttpFoundation\Response
     */

    public function index()
    {
        $restaurants = $this->repository->findAll();
        return $this->render('Admin/restaurant/index.html.twig', compact('restaurants'));
    }

    /**
     * @Route("/admin-restaurant/{id}", name="admin.restaurant.edit")
     * @param Restaurant $restaurant
     * @return \Symfony\Composant\HttpFoundation\Response
     */

    public function edit(Restaurant $restaurant, Request $request)
    {
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->flush();
            return $this->redirectToRoute('admin.restaurant.index');
        }

        return $this->render('Admin/restaurant/edit.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/restaurant/create", name="admin.restaurant.new")
     */

    public function new(Request $request)
    {
        $restaurant = new Restaurant();
        $form = $this->createForm(RestaurantType::class, $restaurant);
        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $this->em->persist($restaurant);
            $this->em->flush();
            return $this->redirectToRoute('admin.restaurant.index');
        }

        return $this->render('Admin/restaurant/new.html.twig', [
            'restaurant' => $restaurant,
            'form' => $form->createView()
        ]);
    }

          /**
       * @Route("/admin/restaurant/{id}", name="admin.restaurant.delete", methods="DELETE")
       * @param Restaurant $restaurant
       * @param Request $request
       * @return \Symfony\Component\HttpFoundation\RedirectResponse
       */

      public function delete(Restaurant $restaurant, Request $request)
      {
          /*
          if($this->isCsrfTokenValid('delete' . $property->getId(), $request->get('_token'))){
          }
          */
           $this->em->remove($restaurant);
           $this->em->flush();
           $this->addFlash('sucess', 'Bien suppromés avec success!');

          return $this->redirectToRoute('admin.restaurant.index'); 
      }
}