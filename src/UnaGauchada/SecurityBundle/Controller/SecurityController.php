<?php

namespace UnaGauchada\SecurityBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use UnaGauchada\UserBundle\Entity\User;

class SecurityController extends Controller
{
    public function loginAction()
    {
        $authUtils = $this->get('security.authentication_utils');
        $error = $authUtils->getLastAuthenticationError();
        $lastUsername = $authUtils->getLastUsername();
        return $this->render('UGSecurityBundle:Login:login.html.twig', array('error' => $error, 'lastUsername' => $lastUsername));
    }

    public function registerAction(){
        return $this->render('UGSecurityBundle:Register:register.html.twig');
    }

    public function signupAction(Request $request){

        // create the user
        $user = new User();
        $user
            ->setName($request->get('name'))
            ->setLastName($request->get('lastName'))
            ->setEmail($request->get('email'))
            ->setIsAdmin(false)
            ->setPlainPassword($request->get('password'))
            ->setPassword('chunk')
            ->setSalt('chunk')
            ->setBirthday(new \DateTime($request->get('birthday')));

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->redirectToRoute('publication_homepage');
    }

}