<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Category;
use AppBundle\Entity\Message;
use AppBundle\Entity\User;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends Controller
{

    /**
     * @Route("/forum", name="forum_index")
     */
    public function showIndexPageAction()
    {
        return $this->render('forum/index.html.twig', []);
    }

    /**
     * @Route("/forum/query", name="forum_show_query")
     */
    public function showQueryAction()
    {
        $entityManager = $this->getDoctrine()->getManager();
        $queryData = $entityManager->getRepository('AppBundle:Messages')->findAllQueringRows();
        return $this->render('forum/query.html.twig', [
            'data' => $queryData,
        ]);
    }

}