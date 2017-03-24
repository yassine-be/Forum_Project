<?php

namespace AppBundle\Controller;

use AppBundle\Entity\discussion;
use AppBundle\Entity\theme;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Form\Extension\Core\Type\DateTimeType;

class DiscussionController extends Controller
{

    /**
     * @Route("/discussions/{id}", name = "discussion_list")
     */
    public function indexDiscussionsAction( $id, Request $request)
    {
        date_default_timezone_set('Europe/Paris');


        // list discussions
        $discussion = $this -> getDoctrine()
            ->getRepository('AppBundle:discussion')
            ->findByThemeId($id);


        // add discussion
        $newDiscussion = new discussion();

        $theme = $this -> getDoctrine()
            ->getRepository('AppBundle:theme')
            ->findOneById($id);



        $form = $this->createFormBuilder($newDiscussion)
            ->add('message', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Add discussion', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            $date = $this->updated = new \DateTime("now");


            // get DATA
            $message = $form['message']->getData();


            $newDiscussion->setTheme($theme);
            $newDiscussion->setMessage($message);
            $newDiscussion->setPseudo('jumper');
            $newDiscussion->setDateTime($date);




            $em = $this->getDoctrine()->getManager();

            $em->persist($newDiscussion);
            $em->flush();

            $this->addFlash(
                'notice',
                'discussion ajouté'
            );

            $last_entity = $this->getDoctrine()->getManager()
                ->createQueryBuilder()
                ->select('e')
                ->from('AppBundle:Discussion', 'e')
                ->where('e.themeId = :identifier ')
                ->orderBy('e.id', 'DESC')
                ->setParameter('identifier', $id)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
            $last_date = $last_entity->getDateTime();

            $theme->setLastDiscussion($last_date);
            $theme->setNbDiscussions($theme->getNbDiscussions()+1);

            $em->persist($theme);
            $em->flush();







            return $this->redirect($this->generateUrl('discussion_list', array('module' => 'input',
                'id' => $id )));


        }

        return $this->render("view/discussions.html.twig", array('discussion' => $discussion,
            'form' => $form->createView()));





    }



    /**
     * @Route("/discussions/{id}/editDiscussion/{id2}", name = "edit_discussion")
     */
    public function editDiscussionAction( $id, $id2, Request $request)
    {

        $discussion = $this -> getDoctrine()
            ->getRepository('AppBundle:discussion')
            ->find($id2);

        $discussion->setMessage($discussion->getMessage());


        $form = $this->createFormBuilder($discussion)
            ->add('message', TextareaType::class, array('attr' => array('class' => 'form-control', 'style' => 'margin-bottom:15px')))
            ->add('save', SubmitType::class, array('label' => 'Edit discussion', 'attr' => array('class' => 'btn btn-primary', 'style' => 'margin-bottom:15px')))
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){


            // get DATA
            $message = $form['message']->getData();




            $discussion->setMessage($message);



            $em = $this->getDoctrine()->getManager();

            $em->persist($discussion);
            $em->flush();

            $this->addFlash(
                'notice',
                'discussion ajouté'
            );

            return $this->redirect($this->generateUrl('discussion_list', array('module' => 'input',
                'id' => $id)));


        }




        return $this->render("view/editDiscussion.html.twig",
            array('form' => $form->createView() ));



    }


    /**
     * @Route("/discussions/{id}/deleteDiscussion/{id2}", name = "delete_discussion")
     */
    public function deleteDiscussionsAction( $id, $id2, Request $request)
    {

        $em = $this ->getDoctrine()->getManager();
        $discussion = $this->getDoctrine()->getRepository('AppBundle:discussion')
            ->find($id2);

        $theme = $this -> getDoctrine()
            ->getRepository('AppBundle:theme')
            ->findOneById($id);

        $em->remove($discussion);
        $em->flush();



        $this->addFlash(
            'notice',
            'discussion supprimé'
        );

        $last_entity = $this->getDoctrine()->getManager()
            ->createQueryBuilder()
            ->select('e')
            ->from('AppBundle:Discussion', 'e')
            ->where('e.themeId = :identifier ')
            ->setParameter('identifier', $id)
            ->getQuery()
            ->getOneOrNullResult();

        if( $last_entity == null){
            $last_date = null;
        }else {
            $last_entity = $this->getDoctrine()->getManager()
                ->createQueryBuilder()
                ->select('e')
                ->from('AppBundle:Discussion', 'e')
                ->where('e.themeId = :identifier ')
                ->orderBy('e.id', 'DESC')
                ->setParameter('identifier', $id)
                ->setMaxResults(1)
                ->getQuery()
                ->getOneOrNullResult();
            $last_date = $last_entity->getDateTime();

            }

        $theme->setLastDiscussion($last_date);
        $theme->setNbDiscussions($theme->getNbDiscussions()-1);

        $em->persist($theme);
        $em->flush();

        return $this->redirect($this->generateUrl('discussion_list', array('module' => 'input',
            'id' => $id)));




    }


}
