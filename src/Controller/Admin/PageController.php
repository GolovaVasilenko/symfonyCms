<?php

namespace App\Controller\Admin;

use App\Entity\Page;
use App\Form\PageType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class PageController extends AdminController
{
    /**
     * @Route("/admin/page", name="admin_page")
     */
    public function index(): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Page List';
        return $this->render('admin/page/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/page/data/table", name="admin_page_data_table", methods={"POST"})
     */
    public function getDataTable(): JsonResponse
    {
        $pages = $this->getDoctrine()
            ->getRepository(Page::class)
            ->getPageList();

        return $this->json(['data' => $pages]);
    }

    /**
     * @Route("/admin/page/create", name="admin_page_create", methods={"POST"})
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createPage(Request $request): Response
    {
        $page = new Page();
        $form = $this->createForm(PageType::class, $page);
        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $page->setUpdatedAt((new \DateTime('NOW'))->format('Y-m-d H:i'));
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute("admin_user");
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Create New Page';
        $forRender['form'] = $form->createView();
        return $this->render('admin/page/form.html.twig', $forRender);
    }
}
