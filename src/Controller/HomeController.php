<?php
namespace App\Controller;

use App\Entity\Restaurant;
use App\Repository\RestaurantRepository;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Twig\Environment;

class HomeController extends AbstractController{

    /**
     * @Route("/", name="home")
     * @param RestaurantRepository $repository2
     * @return Response
     */
    public function index (RestaurantRepository $repository2){
        $restaurants = $repository2->findLatest();
        return $this->render('pages/home.html.twig',[
            'restaurants' => $restaurants, 
        ]);
    }

    /**
     * @Route("/test/test")
     */
    public function hoho (){
        return $this->render('pages/home2.html.twig');
        //return new Response('hello');
    }

    /**
     * @Route("/news/{slug}")
     */
    public function show ($slug){
        //return new Response($this->twig->render('pages/home.html.twig'));
        return new Response(sprintf(
            'future page to show article : %s',
            $slug
            ));
    }
    
}