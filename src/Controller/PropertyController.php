<?php

namespace App\Controller;

use App\Entity\Property;
use App\Repository\PropertyRepository;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\Common\Persistence\ObjectManager;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PropertyController extends AbstractController{

    /**
    * @var PropertyRepository
    */
    
    private $repository;

    /**
     * @var ObjectManager
     */

    private $em;

    public function __construct(PropertyRepository $repository, ObjectManager $em){
        $this->repository = $repository;
        $this->em = $em;
    }


     /**
     * @Route("/biens", name="property.index")
     * @return Response
     */
    public function index(): Response{

        /*
        $property = new Property();
        $property->setTitle('Mon seconde bien')
        ->setPrice(12000)
        ->setRooms(3)
        ->setBedrooms(3)
        ->setDescription('good')
        ->setSurface('160')
        ->setFloor(5)
        ->setHeat(1)
        ->setCity('Paris')
        ->setAddress('16 avenue de egypet')
        ->setPostalCode('31000');

        $em = $this->getDoctrine()->getManager();
        $em->persist($property);
        $em->flush();
        */
        
        //dans le fichier ProppertyRespository.php, on écrit une fonction findAllVisible
        $property = $this->repository->findBy([
            'sold' => false,
            ]);
       // $property[0]->setSold(false);
        //dump($property[0]);
        

        return $this->render('property/index.html.twig',[
            'current_menu' => 'properties'   
        ]);
    }

    /**
     *@Route("/biens/{slug}-{id}", name="property.show", requirements={"slug": "[a-z0-9\-]*"})
     *@return response
     */
    public function show(Property $property, string $slug) : Response
    {
        //$property = $this->repository->find($id);
        if($property->getSlug() !== $slug){
            return $this->redirectRoute('property.show', [
                'property' => $property,
                'current_menu' => 'properties'
            ], 301);
        }
        return $this->render('property/show.html.twig',[
            'property' => $property,
            'current_menu' => 'proerties'
        ]);
    }
}