<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 25/03/2017
 * Time: 08:19
 */

namespace BlogBundle\Controller;

use BlogBundle\BlogBundle;
use BlogBundle\Entity\Post;
use BlogBundle\Form\CommentType;
use BlogBundle\Form\PostType;
use BlogBundle\Form\CategoryType;
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
 * Admin controller.
 *
 * @Route("/")
 */
class AdminController extends Controller
{

    /**
     * Displays admin panel.
     *
     * @Route("/admin", name="admin_show")
     * @Method("GET")
     */
    public function adminAction()
    {
        $em = $this->getDoctrine()->getManager();
        $posts = $em->getRepository('BlogBundle:Post')->getAllPosts();
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
        foreach ( $post->getComments() as $com){
            $post->removeComment($com);
        }
        $em->remove($post);
        $this->addFlash('success', 'Votre article a été supprimé avec succès !');
        $em->flush($post);
        return $this->redirectToRoute('admin_show');
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
        $category = $em->getRepository('BlogBundle:Category')->find($id);
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

}