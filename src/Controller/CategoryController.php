<?php
// src/Controller/BlogController.php
namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\CategoryType;

class CategoryController extends AbstractController
{

    /**
     * @Route("/contact", name="add_category")
     */

    public function add(Request $request): Response
    {
        $form = $this->createForm(CategoryType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted()) {
            $data = $form->getData();
            $category = $this->getDoctrine()->getManager();
            $category->persist($data);
            $category->flush();

            return $this->render(
                'contact/index.html.twig',[
                'form' => $form->createView()]

            );
        }
            else {
              return $this->render(
                'contact/index.html.twig', [
                  'form' => $form->createView()
                ]
                );
                 }
    }

}