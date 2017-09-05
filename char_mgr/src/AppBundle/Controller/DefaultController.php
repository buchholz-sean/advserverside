<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\Email as EmailConstraint;
use Symfony\Component\Form\Extension\Core\Type\FileType;
use Symfony\Component\Validator\Constraints\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

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

        return $this->render('default/index.html.twig', array(
            'charsList' => $charsList
        ));
    }

    /**
     * @Route("/registerForm", name="registerForm")
     */
    public function registerForm(Request $req)
    {
        $form = $this->createFormBuilder(null)
        ->setAction($this->generateUrl("registerForm"))
        ->add("name", TextType::class, array("required"=>true,"constraints"=>[
            new NotBlank(array("message"=>"This field cannot be blank"))
            ]))
        ->add("email", TextType::class, array("required"=>true,"constraints"=>[
            new EmailConstraint(array("message"=>"This field must be a valid email address")),
            new NotBlank(array("message"=>"This field cannot be blank"))
            ]))
        ->add("myFile", FileType::class, array("constraints"=>[
            new File(
                array(
                "maxSize"=>"2M",
                "mimeTypes" => [
                    'application/pdf',
                    'application/x-pdf'
                    ],
                "mimeTypesMessage" => "Please upload a valid PDF")
            )
            ]))
        ->add("save", SubmitType::class)
        ->getForm();

        $form->handleRequest($req);

        if ($req->isMethod("POST")) {
            if ($form->isValid()) {
                $file = $form->get("myFile")->getData();
                $fileName = md5(uniqid()).".".$file->guessExtension();
                $file->move("/Users/SeanBuchholz/Desktop/proj", $fileName);
                
                return $this->render("form/submitted.html.twig", array("title"=>"Register"));
            }
        };

        return $this->render("form/form.html.twig", array("title"=>"Register", "form"=>$form->createView()));
    }
}
