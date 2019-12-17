<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Message;
use AppBundle\Entity\Messages;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends Controller
{

    /**
     * @Route("/", name="forum_index")
     */
    public function showIndexPage()
    {
        return $this->render('forum/index.html.twig', []);
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

        if(!$userId || !$categoryId) {
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
                'category_id' => $categoryId),
                200);
        }

//        return new Response($request);
//        return new JsonResponse($request->request->get('request'));
//        $username = $request->request->get('username');
//        $response = new Response($entityManager->getRepository('AppBundle:Users')->findOneByUsername($username));
//        $response = $entityManager->getRepository('AppBundle:Users')->findOneByUsername($username);

//        die;
//        $username = $request->request->get('id');
//        die;
//        return new Response($response);
    }
}