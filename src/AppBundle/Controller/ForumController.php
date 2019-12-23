<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categories;
use AppBundle\Entity\Category;
use AppBundle\Entity\Message;
use AppBundle\Entity\Messages;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends Controller
{

    /**
     * @Route("/", name="forum_index")
     */
    public function showIndexPage()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $categories = $entityManager->getRepository('AppBundle:Categories')->findBy(['parent' => null]);
        return $this->render('forum/index.html.twig', [
            'categories' => $categories
        ]);
    }

    /**
     * @Route("/showCategory={categoryName}", name="forum_category")
     */
    public function showCategoryPage($categoryName)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository('AppBundle:Categories')->findOneBy(['categoryName' => $categoryName]);
        return $this->render('forum/category.html.twig', [
            'category' => $category,
        ]);
    }

    /**
     * @Route("/query", name="forum_show_query")
     */
    public function showQuery()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $queryData = $entityManager->getRepository('AppBundle:Messages')->findAllQueringRows();
        return $this->render('forum/query.html.twig', [
            'data' => $queryData,
        ]);
    }

    /**
     * @Route("/new", name="forum_new_message")
     */
    public function showNewMessagePage()
    {
        return $this->render('forum/newMessage.html.twig', []);
    }

    /**
     * @Route("/new/send", name="forum_send_message")
     */
    public function newMessageAction(Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();

        $userName = $request->get('name');
        $categoryName = $request->get('category_name');
        $messageText = $request->get('text');

        $userId = $entityManager->getRepository('AppBundle:Users')->findOneByUserName($userName);
        $categoryId = $entityManager->getRepository('AppBundle:Categories')->findOneByCategoryName($categoryName);

        if (!$userId || !$categoryId) {
            return new JsonResponse(array(
                'status' => 'Error',
                'message' => 'Error'),
                400);
        }
        else {
            $newMessage = new Messages($userId, $categoryId, $messageText);
            $entityManager->persist($newMessage);
            $entityManager->flush();
            return new JsonResponse(array(
                'status' => 'OK',
                'user_id' => $userId,
                'category_id' => $categoryId,
                'message_id' => $newMessage->getId()),
                200);
        }
    }
}