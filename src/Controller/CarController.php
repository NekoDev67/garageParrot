<?php

namespace App\Controller;

use App\Entity\Car;
use App\Form\CarType;
use App\Repository\CarRepository;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class CarController extends AbstractController
{
    /**
     * This function display all cars
     *
     * @param CarRepository $respository
     * @param PaginatorInterface $paginator
     * @param Request $request
     * @return Response
     */

    #[Route('/car', name: 'car', methods:['GET'])]
    public function index(CarRepository $respository, PaginatorInterface $paginator, Request $request): Response
    {
        $cars = $paginator->paginate(
            $respository->findAll(),
            $request->query->getInt('page', 1), 3
        );
        return $this->render('pages/car/index.html.twig', [
            'cars' =>  $cars
        ]);
    }

    #[Route('/car/new', 'car.new', methods:["GET", "POST"])]
    public function new(Request $request, EntityManagerInterface $manager) : Response
    {
        $car = new Car();
        $form = $this->createForm(CarType::class, $car);

        $form->handleRequest($request);
        
        if($form->isSubmitted() && $form->isValid())
        {
            $car = $form->getData();
            $manager->persist($car);
            $manager->flush();
            
            $this->addFlash(
                'success',
                'Votre voiture a bien été envoyé !',
            );

            return $this->redirectToRoute('home.index');
        }

        return $this->render('pages/car/new.html.twig', [
            'form' => $form->createView()
        ]);
    }
}
