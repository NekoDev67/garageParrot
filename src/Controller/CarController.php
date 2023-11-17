<?php

namespace App\Controller;

use App\Repository\CarRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class CarController extends AbstractController
{
    #[Route('/car', name: 'app_car')]
    public function index(CarRepository $respository): Response
    {
        
        return $this->render('pages/car/index.html.twig', [
            'cars' => $respository->findAll()
        ]);
    }
}
