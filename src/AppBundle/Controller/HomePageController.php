<?php

namespace AppBundle\Controller;

use AppBundle\Entity\theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\HttpFoundation\Request;

class HomePageController extends Controller
{
    /**
     * @Route("/", name = "Theme_list")
     */
    public function indexThemeAction()
    {
        $theme = $this -> getDoctrine()
            ->getRepository('AppBundle:theme')
            ->findAll();




        return $this->render("view/index.html.twig", array('theme' => $theme));
    }



    /**
     * @Route("/addTheme")
     */
    public function addThemeAction(Request $request)
    {

        $theme = new theme();

        $form = $this->createFormBuilder($theme)
            ->add('nom', TextType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Create Theme', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            // Get Data
            $nom = $form['nom']->getData();


            $theme->setNom($nom);
            $theme->setLastDiscussion(null);
            $theme->setNbDiscussions(0);


            $em = $this->getDoctrine()->getManager();

            $em->persist($theme);
            $em->flush();

            $this->addFlash(
                'notice',
                'theme ajouté'
            );

            return $this->redirectToRoute('Theme_list');

        }

        return $this->render("view/addTheme.html.twig", array(
            'form' => $form->createView()
        ));
    }


    /**
     * @Route("/deleteTheme/{id}", name = "delete_theme")
     */
    public function deleteThemeAction( $id , Request $request)
    {

        $em = $this ->getDoctrine()->getManager();

        $theme = $this -> getDoctrine()
            ->getRepository('AppBundle:theme')
            ->findOneById($id);


        $em->remove($theme);
        $em->flush();



        $this->addFlash(
            'notice',
            'thème supprimé'
        );

        return $this->redirect($this->generateUrl('Theme_list', array('module' => 'input',)));




    }



}
