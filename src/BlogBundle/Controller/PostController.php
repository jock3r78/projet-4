<?php

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
        $query = $em->getRepository('BlogBundle:Post')->getPostWithCategoryAndUserQuery();
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
     * Finds and displays a post entity.
     *
     * @Route("/{id}", name="post_show", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('BlogBundle:Post')->getOnePostWithCategoryAndUserAndComment($id);

        $comments = $em->getRepository('BlogBundle:Comment')->findBy(array('parent' => null, 'post' => $post));


        return $this->render('BlogBundle:Default:show.html.twig', array(
            'post' => $post,
            'comments' => $comments,
        ));
    }

    /**
     *
     * @Route("/{id}/add_comment", name="add_comment", requirements={"id": "\d+"})
     * @Method("POST")
     */
    public function addCommentAction(Request $request, Post $post)
    {
        $em = $this->getDoctrine()->getManager();
        // Add comment
        $comment = new Comment();
        $form = $this->get('form.factory')->create(CommentType::class, $comment, array(
            'action' => $this->generateUrl('add_comment', array('id' => $post->getId())),
            'method' => 'POST',
        ));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $comment->setPost($post);

            $em->persist($comment);
            $em->flush();
            $this->addFlash('success', 'Votre commentaire a été ajouté avec succès !');

            return $this->redirectToRoute('post_show', array('id' => $post->getId()));
        }

        return $this->render('BlogBundle:Default:add-comment.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     *
     *
     * @Route("/{id}/add_comment/{comment_parent_id}", name="add_comment_response", requirements={"id": "\d+"})
     * @Method("POST")
     */
    public function addCommentResponseAction(Request $request, Post $post, $comment_parent_id)
    {
        $em = $this->getDoctrine()->getManager();
        $commentParent = $em->getRepository('BlogBundle:Comment')->find($comment_parent_id);
        // Add comment
        $comment = new Comment();
        $comment->setPost($post);
        $comment->setLevel($commentParent->getLevel() + 1);
        $comment->setParent($commentParent);
        $form = $this->get('form.factory')->create(CommentType::class, $comment, array(
            'action' => $this->generateUrl('add_comment_response', array('id' => $post->getId(), 'comment_parent_id' => $comment_parent_id)),
            'method' => 'POST'
        ));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {

            $em->persist($comment);
            $em->flush();
            $this->addFlash('success', 'Votre réponse a été ajouté avec succès !');

            return $this->redirectToRoute('post_show', array('id' => $post->getId()));
        }

        return $this->render('BlogBundle:Default:add-comment.html.twig', array(
            'form' => $form->createView()
        ));
    }

    /**
     * Finds and displays author post entity.
     *
     * @Route("/author/{id}", name="author_show", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function authorAction(User $user, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('BlogBundle:Post')->getAuthorPosts($id);

        return $this->render('BlogBundle:Default:show-author-post.html.twig', array(
            'author' => $user,
            'posts' => $posts
        ));
    }

    /**
     * Finds and displays category post entity.
     *
     * @Route("/category/{id}", name="category_show", requirements={"id": "\d+"})
     * @Method("GET")
     */
    public function categoryAction(Category $category, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('BlogBundle:Post')->getCategoryPosts($id);

        return $this->render('BlogBundle:Default:show-category-post.html.twig', array(
            'category' => $category,
            'posts' => $posts
        ));
    }


    /**
     * Displays admin panel.
     *
     * @Route("/admin", name="admin_show")
     * @Method("GET")
     */
    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('BlogBundle:Post')->getPostWithCategoryAndUser();
        $form = $this->get('form.factory')->create();

        return $this->render('BlogBundle:Admin:admin-index.html.twig', array(
            'posts' => $posts,
            'form' => $form->createview(),
        ));
    }

    /**
     * Creates a new post entity.
     *
     * @Route("/admin/new", name="admin_post_new")
     * @Method({"GET", "POST"})
     */
    public function newAction(Request $request)
    {
        $post = new Post();
        $form = $this->get('form.factory')->create(PostType::class, $post, array('user' => $this->getUser()->getUsername()));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($post);
            $em->flush();
            $this->addFlash('success', 'Votre article a été ajouté avec succès !');

            return $this->redirectToRoute('admin_show');
        }

        return $this->render('BlogBundle:Admin:admin-new.html.twig', array(
            'form' => $form->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing post entity.
     *
     * @Route("/admin/edit/{id}", name="admin_post_edit")
     * @Method({"GET", "POST"})
     */
    public function editAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $post = $em->getRepository('BlogBundle:Post')->getOnePostWithCategoryAndUserAndComment($id);
        $commentReport = $em->getRepository('BlogBundle:Comment')->getCommentReport($id);

        $form = $this->createForm(PostType::class, $post, array('user' => $this->getUser()->getUsername()));

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Votre article a été modifié avec succès !');

            return $this->redirectToRoute('admin_show');
        }

        return $this->render('BlogBundle:Admin:admin-edit.html.twig', array(
            'form' => $form->createView(),
            'post' => $post,
            'commentReport' => $commentReport
        ));
    }

    /**
     * Deletes a post entity.
     *
     * @Route("/admin/delete", name="admin_post_delete")
     * @Method("POST")
     */
    public function deleteAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('POST_ID');

        $post = $em->getRepository('BlogBundle:Post')->find($id);
        $em->remove($post);
        $this->addFlash('success', 'Votre article a été supprimé avec succès !');
        $em->flush($post);

        return $this->redirectToRoute('admin_show');
    }

    /**
     * Deletes a comment entity.
     *
     * @Route("/admin/delete-comment", options={"expose"=true}, name="admin_comment_delete")
     * @Method("POST")
     */
    public function deleteCommentAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('COMMENT_ID');


        $comment = $em->getRepository('BlogBundle:Comment')->find($id);
        $em->remove($comment);
        $this->addFlash('success', 'Votre article a été supprimé avec succès !');
        $em->flush($comment);

        return $this->redirectToRoute('admin_comments');

    }

    /**
     * Set reportComment bool
     *
     * @Route("/setreport", options={"expose"=true}, name="set_report")
     * @Method("POST")
     */
    public function setReportAction(Request $request)
    {
        if ($request->isXmlHttpRequest()) {
            $data = $request->request->all();
            $id = $data['Comment_ID'];
            // $session = $request->getSession();
            // $session->set('panier', $data);
        }

        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('BlogBundle:Comment')->find($id);
        $reportNumber = $comment->getReport();
        $newReportNumber = $reportNumber + 1;
        $comment->setReport($newReportNumber);

        $em->persist($comment);
        $em->flush();


        return new Response('success');
    }


    /**
     * Displays admin panel comments.
     *
     * @Route("/admin/comments", name="admin_comments")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function admincommentsAction()
    {
        $em = $this->getDoctrine()->getManager();
        $comments = $em->getRepository('BlogBundle:Comment')->getAllComments();
        $form = $this->get('form.factory')->create();

        return $this->render('BlogBundle:Admin:admin-comment.html.twig', array(
            'comments' => $comments,
            'form' => $form->createview(),
        ));
    }


    /**
     * Displays admin panel category.
     *
     * @Route("/admin/category", name="admin_category")
     * @Security("has_role('ROLE_ADMIN')")
     * @Method({"GET", "POST"})
     */
    public function categoryadminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $categorys = $em->getRepository('BlogBundle:Category')->getAllCategorys();
        $form = $this->get('form.factory')->create();

        return $this->render('BlogBundle:Admin:admin-category.html.twig', array(
            'category' => $categorys,
            'form' => $form->createview(),
        ));
    }

    /**
     * Displays a form to edit an existing comment entity.
     *
     * @Route("/admin/comments/edit/{id}", name="admin_comment_edit")
     * @Method({"GET", "POST"})
     */
    public function editcommentAction(Request $request, Comment $comment, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $comment = $em->getRepository('BlogBundle:Comment')->find($id);
        $form = $this->createForm(CommentType::class, $comment);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Votre Commentaire a été modifié avec succès !');

            return $this->redirectToRoute('admin_comments');
        }

        return $this->render('BlogBundle:Admin:admin-comment-edit.html.twig', array(
            'form' => $form->createView(),
            'comment' => $comment
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
     *
     * @Route("/{id}/report", name="comment_report")
     *
     */
    public function reportAction(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $com = $em->getRepository('BlogBundle:Comment')->find($comment->getId());
        $report = $com->getReport();
        $post = $com->getPost();
        $report = $report + 1;
        $com->setReport($report);
        $em->persist($com);
        $em->flush();
        return $this->redirectToRoute('post_show', array(
            'id' => $post->getId()
        ));

    }

    /**
     * @Route("/admin/comment/moderate/{id}", name="comment_moderate")
     *
     */
    public function moderateAction(Comment $comment)
    {
        $em = $this->getDoctrine()->getManager();
        $com = $em->getRepository('BlogBundle:Comment')->find(array('id' => $comment->getId()));

        $com->setUsername(' XXXXXXXXXXX');
        $com->setContent('Ce commentaire a été modéré - Contenu jugé abusif');
        $com->setReport(0);
        $em->persist($com);
        $em->flush();

        return $this->redirectToRoute('admin_comments');
    }


    /**
     * Displays a form to edit an existing category entity.
     *
     * @Route("/admin/category/edit/{id}", name="admin_category_edit")
     * @Method({"GET", "POST"})
     */
    public function editcategoryAction(Request $request, Category $category, $id)
    {
        $em = $this->getDoctrine()->getManager();
        $category = $em->getRepository('BlogBundle:Catgeory')->find($id);
        $form = $this->createForm(CategoryType::class, $category);

        if ($request->isMethod('POST') && $form->handleRequest($request)->isValid()) {
            $em->flush();
            $this->addFlash('success', 'Votre Category a été modifié avec succès !');

            return $this->redirectToRoute('admin_category');
        }

        return $this->render('BlogBundle:Admin:admin-category-edit.html.twig', array(
            'form' => $form->createView(),
            'category' => $category
        ));
    }
    /**
     * Deletes a category entity.
     *
     * @Route("/admin/delete-category", options={"expose"=true}, name="admin_category_delete")
     * @Method("POST")
     */
    public function deleteCategoryAction(Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $id = $request->request->get('CATEGORY_ID');


        $category = $em->getRepository('BlogBundle:Category')->find($id);
        $em->remove($category);
        $this->addFlash('success', 'Votre catégorie a été supprimé avec succès !');
        $em->flush($category);

        return $this->redirectToRoute('admin_category');

    }

}
