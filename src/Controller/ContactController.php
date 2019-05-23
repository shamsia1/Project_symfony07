<?php

namespace App\Controller;

use App\Form\CategoryType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(): Response
    {
        $form = $this->createForm(CategoryType::class);
        return $this->render('contact/index.html.twig',[
            'our_form' =>$form->createView(),
        ]);

    }
}
