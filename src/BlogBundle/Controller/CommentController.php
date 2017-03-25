<?php
/**
 * Created by PhpStorm.
 * User: jonathan
 * Date: 25/03/2017
 * Time: 08:21
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
 * Admin controller.
 *
 * @Route("/")
 */
class CommentController extends Controller
{

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
        $this->addFlash('success', 'Votre commentaire a été supprimé avec succès !');
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
        $this->addFlash(
            'report',
            'Votre signalement a été pris en compte, Merci.'
        );
        return $this->redirectToRoute('post_show', array(
            'id' => $post->getId()
        ));
    }



}