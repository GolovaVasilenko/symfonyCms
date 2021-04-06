<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Form\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserController extends AdminController
{
    /**
     * @Route("/admin/user", name="admin_user")
     */
    public function index(): Response
    {
        $forRender = parent::renderDefault();
        $forRender['title'] = 'User List';
        $users = $this->getDoctrine()
            ->getRepository(User::class)
            ->findAll();
        return $this->render('admin/user/index.html.twig', [
            'controller_name' => 'UserController',
            'data' => $forRender,
            'users' => $users,
        ]);
    }

    /**
     * @Route("/admin/user/create", name="admin_user_create")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|Response
     */
    public function createUser(Request $request, UserPasswordEncoderInterface $passwordEncoder)
    {
        $user = new User();
        $form = $this->createForm(UserType::class, $user);
        $em = $this->getDoctrine()->getManager();

        $form->handleRequest($request);
        if($form->isSubmitted() && $form->isValid()) {
            $password = $passwordEncoder->encodePassword($user, $user->getPlainPassword());
            $user->setPassword($password);
            $user->setRoles(['ROLE_ADMIN']);
            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute("admin_user");
        }
        $forRender = parent::renderDefault();
        $forRender['title'] = 'Create New User';
        $forRender['form'] = $form->createView();
        return $this->render('admin/user/form.html.twig', $forRender);
    }
}
