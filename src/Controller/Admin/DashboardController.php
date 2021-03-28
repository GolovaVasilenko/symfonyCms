<?php

namespace App\Controller\Admin;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AdminController
{
    /**
     * @Route("/admin", name="admin_dashboard")
     */
    public function index(): Response
    {
        $forRender = parent::renderDefault();
        return $this->render('admin/dashboard/index.html.twig', [
            'controller_name' => 'DashboardController',
            'data' => $forRender,
        ]);
    }
}
