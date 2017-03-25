<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 25/03/2017
 * Time: 08:18
 */

namespace BlogBundle\Controller;
use BlogBundle\BlogBundle;
use BlogBundle\Entity\Post;
use BlogBundle\Form\CommentType;
use BlogBundle\Form\PostType;
use BlogBundle\Entity\User;
use BlogBundle\Entity\Category;
use BlogBundle\Entity\Comment;
use FOS\UserBundle\Doctrine\UserManager;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Security;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Session\Session;


/**
 * Post controller.
 *
 * @Route("/")
 */
class PostController extends Controller
{
    /**
     * Lists all post entities.
     *
     * @Route("/", name="post_index")
     * @Method("GET")
     */
    public function indexAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $query = $em->getRepository('BlogBundle:Post')->getAllPosts();
        $posts = $this->get('knp_paginator')->paginate(
            $query,
            $request->query->getInt('page', 1),
            5
        );
        return $this->render('BlogBundle:Default:index.html.twig', array(
            'posts' => $posts,
        ));
    }



    /**
     * about.
     *
     * @Route("/about", name="about")
     * @Method("GET")
     */
    public function aboutAction()
    {
        return $this->render('BlogBundle:Default:about.html.twig');
    }


    /**
     * Finds and displays a post entity.
     *
     *
     * @Route("/episode/{id}", name="post_show", requirements={"id": "\d+"})
     * @Method({"GET", "POST"})
     */
    public function showAction($id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('BlogBundle:Post')->getOnePostWithCategoryAndUserAndComment($id);
        $comments = $em->getRepository('BlogBundle:Comment')->findBy(array('parent' => null, 'post' => $post));
        // Add comment
        $comment = new Comment();
        $form = $this->get('form.factory')->create(CommentType::class, $comment, array(
            'action' => $this->generateUrl('post_show', array('id' => $post->getId())),
            'method' => 'POST',
        ));
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setPost($post);
            $em->persist($comment);
            $em->flush();
            $this->addFlash('success', 'Votre commentaire a été ajouté avec succès !');
            return $this->redirectToRoute('post_show', array('id' => $post->getId()));
        }
        return $this->render('BlogBundle:Default:show.html.twig', array(
            'form' => $form->createView(),
            'post' => $post,
            'comments' => $comments,
        ));
    }

    /**
     *
     *
     * @Route("/comment-reponse/{id}", name="add_comment_response")
     * @Method("POST")
     */
    public function addCommentResponseAction(Request $request, Comment $comment_parent)
    {
        $em = $this->getDoctrine()->getManager();
        // Add comment
        $comment = new Comment();
        $comment->setParent($comment_parent);
        $form = $this->get('form.factory')->create(CommentType::class, $comment, array(
            'action' => $this->generateUrl('add_comment_response', array('id' => $comment_parent->getId())
        )));
        $form->handleRequest($request);
        if ($form->isSubmitted() ) {
            if ($form->isValid()) {
                $em->persist($comment);
                $em->flush();
                $this->addFlash('success', 'Votre réponse a été ajouté avec succès !');

            } else {
                $this->addFlash('error', 'veuillez remplir les champs dans le formulaire de réponse');
            }
            return $this->redirectToRoute('post_show', array('id' => $comment_parent->getPost()->getId()));


        }

        return $this->render('BlogBundle:Default:add-comment.html.twig', array(
            'form' => $form->createView()
        ));
    }
}
