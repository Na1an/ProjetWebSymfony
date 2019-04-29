<?php

namespace App\Controller;

use App\Entity\Restaurant;
use App\Entity\RestaurantSearch;
use App\Form\RestaurantSearchType;
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

        /*
        $time = "10:30";
        $time2 = "23:30";

        $restaurant = new Restaurant();
        $restaurant->setName('The best food')
        ->setAddress('12 Avenue de ABC')
        ->setTelephone(1234567890)
        ->setStartAt(\DateTime::createFromFormat('H:i', $time))
        ->setCloseAt(\DateTime::createFromFormat('H:i', $time2))
        ->setAveragePrice(100)
        ->setEvaluation(3);

        $em = $this->getDoctrine()->getManager();
        $em->persist($restaurant);
        $em->flush();
        */

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
     *@return response
     */
    public function show(Restaurant $restaurant, string $slug) : Response
    {
        
        if($restaurant->getSlug() !== $slug){
            return $this->redirectRoute('restaurant-list.show', [
                'restaurant' => $restaurant,
                'current_menu' => 'restaurants'
            ], 301);
        }
        return $this->render('restaurant-list/show.html.twig',[
            'restaurant' => $restaurant,
            'current_menu' => 'restaurants'
        ]);
    }
}