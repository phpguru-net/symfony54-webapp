<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/home", name="app_home")
     */
    public function index(): Response
    {
        $var = [
            'a simple string' => "in an array of 5 elements",
            'a float' => 1.0,
            'an integer' => 1,
            'a boolean' => true,
            'an empty array' => [],
        ];
        dump($var);
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/home/sidebar/{username?}", name="app_home_sidebar")
     */
    public function sidebar(Request $request): Response
    {
        $var = [
            'a simple string' => "in an array of 5 elements",
            'a float' => 1.0,
            'an integer' => 1,
            'a boolean' => true,
            'an empty array' => [],
        ];
        dump($var);
        $username = $request->get('username');
        return new Response("
        <aside>Sidebar {$username}</aside>");
    }
}
