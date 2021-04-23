<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use App\Repository\UserRepositoryInterface;
use App\Services\User\UserService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AdminController
{
    protected UserRepositoryInterface $repository;

    protected UserService $userService;

    /**
     * UserController constructor.
     * @param UserRepositoryInterface $repository
     * @param UserService $userService
     */
    public function __construct(UserRepositoryInterface $repository, UserService $userService)
    {
        $this->repository = $repository;
        $this->userService = $userService;
    }

    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function index(): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'User List';
        $forRender['users'] = $this->repository->getAll();
        return $this->render('admin/user/index.html.twig', $forRender);
    }

    /**
     * @Route("/admin/user/create", name="admin_user_create")
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createUser(Request $request)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->userService->handleCreate($user);
            $this->addFlash('success', "User created successful!");
            return $this->redirectToRoute("admin_user");
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Create New User';
        $forRender['form'] = $form->createView();
        return $this->render('admin/user/form.html.twig', $forRender);
    }

    /**
     * @Route("/admin/user/update/{userId}", name="admin_user_update")
     * @param Request $request
     * @param int $userId
     */
    public function updateUser(Request $request, int $userId)
    {
        $user = $this->repository->getOne($userId);
        $form = $this->createForm(UserType::class, $user);

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $this->userService->handleUpdate($user);
            $this->addFlash('success', "User updated successful!");
            return $this->redirectToRoute("admin_user_update", ['userId' => $userId]);
        }

        $forRender = parent::renderDefault();
        $forRender['title'] = 'Update New User';
        $forRender['form'] = $form->createView();
        return $this->render('admin/user/form.html.twig', $forRender);
    }
}
