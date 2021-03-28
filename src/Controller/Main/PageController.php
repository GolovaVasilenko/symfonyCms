<?php

namespace App\Controller\Main;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends FrontController
{
    /**
     * @Route("/", name="home_page")
     */
    public function index(): Response
    {
        $forRender = parent::renderDefault();
        return $this->render('main/page/index.html.twig', [
            'controller_name' => 'PageController',
            'data' => $forRender,
        ]);
    }
}
