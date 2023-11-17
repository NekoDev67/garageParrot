<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Knp\Component\Pager\PaginatorInterface;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
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
}
