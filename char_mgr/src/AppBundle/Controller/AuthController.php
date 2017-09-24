<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;


use Symfony\Component\HttpFoundation\Session\Session;

class AuthController extends Controller
{
    /**
     * @Route("/auth")
     */
    public function loginAction()
    {
        $client= new \Google_Client();
        $client->setApplicationName('Symfony Login');
        $client->setClientId('930325300848-tdrsn4b47ca6bl35jdh3f2uv098ght9e.apps.googleusercontent.com');
        $client->setClientSecret('-b5_QOBB-MlGTORwcVWEeM98');
        $client->addScope('https://www.googleapis.com/auth/plus.me');
        $client->setRedirectUri('http://127.0.0.1:8000/auth/callback');
        $url= $client->createAuthUrl();// to get login url
        echo '<a href="' . $url . '">Log in with Google!</a>';
        die;
    }

    /**
     * @Route("/auth/callback")
     */
    public function verifyCredsAction(Request $request)
    {
        $session = $request->getSession();

        $client= new \Google_Client();
        $client->setApplicationName('Symfony Login');
        $client->setClientId('930325300848-tdrsn4b47ca6bl35jdh3f2uv098ght9e.apps.googleusercontent.com');
        $client->setClientSecret('-b5_QOBB-MlGTORwcVWEeM98');
        $client->setRedirectUri('http://127.0.0.1:8000/auth/callback');
        $service = new \Google_Service_Oauth2($client);
        $code = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($code);
        $userDetails=$service->userinfo->get();
        $user = array(
            'name' => $userDetails['given_name'],
            'fullname' => $userDetails['name'],
            'pic' => $userDetails['picture']
        );
        $session->set('user', $user);
        $session->set('loggedIn', true);
        return $this->redirectToRoute('homepage');
        die;
    }

    /**
     * @Route("/auth/logout")
     */
    public function logoutAction(Request $request)
    {
        $session = $request->getSession();
        $session->invalidate();
        return $this->redirectToRoute('homepage');
    }
}
