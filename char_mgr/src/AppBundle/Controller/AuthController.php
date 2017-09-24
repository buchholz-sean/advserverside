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
        // OAuth Google Social Login
        $client= new \Google_Client();
        // Google Developer Console credentials
        $client->setApplicationName('Symfony Login');
        $client->setClientId('930325300848-tdrsn4b47ca6bl35jdh3f2uv098ght9e.apps.googleusercontent.com');
        $client->setClientSecret('-b5_QOBB-MlGTORwcVWEeM98');
        // Set scope of OAuth request
        $client->addScope('https://www.googleapis.com/auth/plus.me');
        // Redirect URI
        $client->setRedirectUri('http://127.0.0.1:8000/auth/callback');
        // Create login URL
        $url= $client->createAuthUrl();
        // Render 'Log In with Google' page and pass URL
        return $this->render('auth/oauth.html.twig', array(
            'url' => $url
        ));
        die;
    }

    /**
     * @Route("/auth/callback")
     */
    public function verifyCredsAction(Request $request)
    {
        $session = $request->getSession();

        // OAuth Google Social Login
        $client= new \Google_Client();
        // Google Developer Console credentials
        $client->setApplicationName('Symfony Login');
        $client->setClientId('930325300848-tdrsn4b47ca6bl35jdh3f2uv098ght9e.apps.googleusercontent.com');
        $client->setClientSecret('-b5_QOBB-MlGTORwcVWEeM98');
        // Redirect URI
        $client->setRedirectUri('http://127.0.0.1:8000/auth/callback');
        $service = new \Google_Service_Oauth2($client);
        // Get Access Token
        $code = $client->fetchAccessTokenWithAuthCode($_GET['code']);
        $client->setAccessToken($code);
        // Get user information per scope set in `/auth` route
        $userDetails=$service->userinfo->get();
        // Set user information to array
        $user = array(
            'name' => $userDetails['given_name'],
            'fullname' => $userDetails['name'],
            'pic' => $userDetails['picture']
        );
        // Store user in session and log in
        $session->set('user', $user);
        $session->set('loggedIn', true);
        // Redirect user to profile page
        return $this->redirectToRoute('userhome');
        die;
    }

    /**
     * @Route("/auth/logout")
     */
    public function logoutAction(Request $request)
    {
        // Destroy session
        $session = $request->getSession();
        $session->invalidate();
        // Redirect user to homepage
        return $this->redirectToRoute('homepage');
    }
}
