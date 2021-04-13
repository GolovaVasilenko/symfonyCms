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
     * @Route("/admin/page/create", name="admin_page_create", methods={"POST","GET"})
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
            $page->setUpdatedAtValue();
            $page->setCreatedAtValue();
            $em->persist($page);
            $em->flush();

            return $this->redirectToRoute("admin_page");
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Create New Page';
        $forRender['form'] = $form->createView();
        return $this->render('admin/page/form.html.twig', $forRender);
    }

    /**
     * @Route("/admin/page/update/{id}", name="admin_page_update", methods={"POST","GET"})
     * @param Request $request
     * @return Response
     */
    public function updatePage(Request $request): Response
    {
        $page = $this->getDoctrine()
            ->getRepository(Page::class)
            ->find($request->get('id'));

        $form = $this->createForm(PageType::class, $page);
        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $page->setUpdatedAtValue();
            $em->persist($page);
            $em->flush();
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Update Page';
        $forRender['form'] = $form->createView();
        $forRender['page'] = $page;
        return $this->render('admin/page/form.html.twig', $forRender);
    }

    /**
     * @Route("/admin/page/delete/{id}", name="admin_page_delete", methods={"POST"})
     * @param Request $request
     * @return JsonResponse
     */
    public function removePage(Request $request)
    {
        $page = $this->getDoctrine()
            ->getRepository(Page::class)
            ->find($request->get('id'));
        $em = $this->getDoctrine()->getManager();
        if(!empty($page)) {
            $em->remove($page);
            $em->flush();
            return $this->json(['status' => 1]);
        }
        return $this->json(['status' => 0]);
    }
}
