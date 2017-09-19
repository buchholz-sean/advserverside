<?php
namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CharController extends Controller
{
    /**
     * @Route("/chars/{charName}")
     */
    public function showAction($charName)
    {
        return $this->render('chars/show.html.twig', array(
            'name' => $charName,
        ));
    }
}
