<?php

namespace App\Controller;



use Rompetomp\InertiaBundle\Service\InertiaInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="home")
     * @param InertiaInterface $inertia
     * @return Response
     */
    public function index(InertiaInterface $inertia): Response
    {
        return $inertia->render('Home', ['prop' => 'propValue']);
    }

}