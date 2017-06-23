<?php

namespace UserBundle\Controller;

use IMG\ShopBundle\Entity\Cart;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use UserBundle\Entity\Role;
use UserBundle\Entity\User;
use UserBundle\Form\UserType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class SecurityController extends Controller
{
    /**
     * @Route("/login", name="user_login")
     * @Template()
     */
    public function loginAction()
    {
        $auth_utils = $this->get('security.authentication_utils');
        $error = $auth_utils->getLastAuthenticationError();
        $last_username = $auth_utils->getLastUsername();
        return [
            'error'         => $error,
            'last_username' => $last_username
        ];
    }

    /**
     * @Route("/register", name="user_register")
     * @Template()
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function registerAction (Request $request)
    {
        $userEntity = new User();

        $form = $this->createForm(UserType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {


            /** @var $userEntity User*/
            $userEntity = $form->getData();

            $encoderService = $this->get('security.password_encoder');
            $passwordHash = $encoderService->encodePassword($userEntity,$userEntity->getPasswordRaw());
            $userEntity->setPassword($passwordHash);

            $userRoleEntity = $this->getDoctrine()->getRepository(Role::class)->findOneBy(['name' => Role::getDefaultRole()]);
            $userEntity->addRole($userRoleEntity);

            $em = $this->getDoctrine()->getManager();

            $em->persist($userEntity);
            $em->flush();

            // add first cart to user
            $em->getRepository(Cart::class)->createNewCard($userEntity);

            //auto login after register
            $token = new UsernamePasswordToken($userEntity, null, 'main', $userEntity->getRoles());
            $this->get('security.token_storage')->setToken($token);
            //$this->get('session')->set('_security_main',serialize($token));

            return $this->redirectToRoute('shop_index');
        }
        
        return [
            'register_form' => $form->createView()
        ];
    }
    /**
     * @Route("/logout", name="user_logout")
     */
    public function logout()
    {
        // its empty because symfony just need the route..
    }
}
