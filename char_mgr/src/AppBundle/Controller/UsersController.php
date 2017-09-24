<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\HttpFoundation\Session\Session;

class UsersController extends Controller
{
    /**
     * @Route("/users", name="userhome")
     */
    public function profileAction(Request $request)
    {
        $session = $request->getSession();
        $loggedIn = $session->get('loggedIn');
        // Check if user is logged in
        if ($loggedIn && $loggedIn === true) {
            // If so, take user to profile page
            return $this->render('users/profile.html.twig');
        } else {
            // If not, take user to homepage
            return $this->redirectToRoute('homepage');
        }
    }
}
