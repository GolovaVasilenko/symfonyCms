<?php
namespace App\Controller\Main;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

class FrontController extends AbstractController
{
    /**
     * @return string[]
     */
    public function renderDefault() : array
    {
        return [
            'title' => 'Default Title',
        ];
    }
}