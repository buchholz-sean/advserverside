<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $charsList = array(
            "Aldara" => "Wizard",
            "Arder" => "Immolator",
            "Astrafel" => "Bard",
            "Cecil" => "Barbarian",
            "Dru" => "Druid",
            "Erroll" => "Thief",
            "Niskadora" => "Ranger"
        );

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'charsList' => $charsList
        ));
    }
}
