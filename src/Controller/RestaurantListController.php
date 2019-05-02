<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\RestaurantSearch;
use App\Entity\Reserver;
use App\Form\RestaurantSearchType;
use App\Form\ReserverType;
use App\Notification\ReserverNotification;
use \DateTime;
use App\Repository\RestaurantRepository;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;


class RestaurantListController extends AbstractController{ 

    /**
    * @var RestaurantRepository
    */
    
    private $repository;

    /**
     * @var ObjectManager
     */

    private $em;

    public function __construct(RestaurantRepository $repository, ObjectManager $em){
        $this->repository = $repository;
        $this->em = $em;
    }

    /**
     * @Route("/restaurant-list", name="restaurant-list")
     * @return Response
     */

     public function index(PaginatorInterface $paginator, Request $request  ): Response{

        $search = new RestaurantSearch();
        $form = $this->createForm(RestaurantSearchType::class, $search);
        $form->handleRequest($request);

        $restaurant = $paginator->paginate(
            $this->repository->findAllVisibleQuery($search),
            $request->query->getInt('page', 1),
            12
        );
        return $this->render('restaurant-list/list.html.twig',[
            'current_menu' => 'restaurantlist',
            'restaurants' => $restaurant,
            'form' => $form->createView(),
        ]);


     }

     /**
     *@Route("/restaurant-list/{slug}-{id}", name="restaurant-list.show", requirements={"slug": "[a-z0-9\-]*"})
     *@param Restaurant $restaurant
     *@return response
     */
    public function show(Restaurant $restaurant, string $slug, Request $request, ReserverNotification $notificaition) : Response
    {
        if($restaurant->getSlug() !== $slug){
            return $this->redirectToRoute('restaurant-list.show', [
                'id' => $restaurant->getId(),
                'slug' => $restaurant->getSlug()
            ], 301);
        }

        $reserver = new Reserver();
        $reserver->setRestaurant($restaurant); 
        $form = $this->createForm(ReserverType::class, $reserver);
        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid()){
            $notificaition->notify($reserver);
            $this->addFlash('sucess', 'votre e-mail a bien été envoyé !');
            
            return $this->redirectToRoute('restaurant-list.show', [
                'id' => $restaurant->getId(),
                'slug' => $restaurant->getSlug()
            ]);
        }

        return $this->render('restaurant-list/show.html.twig',[
            'restaurant' => $restaurant,
            'current_menu' => 'restaurants',
            'form' => $form->createView()
        ]);
    }
}