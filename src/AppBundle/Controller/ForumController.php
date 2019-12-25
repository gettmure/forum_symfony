<?php

namespace AppBundle\Controller;

use AppBundle\Entity\Categories;
use AppBundle\Entity\Messages;
use AppBundle\Entity\Users;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use AppBundle\Form\MessageFormType;

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
    public function showCategoryPage($categoryName, Request $request)
    {
        $entityManager = $this->getDoctrine()->getManager();
        $category = $entityManager->getRepository('AppBundle:Categories')->findOneBy(['categoryName' => $categoryName]);

        $form = $this->createForm(MessageFormType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()){
            $data = $form->getData();

            $author = $entityManager->getRepository('AppBundle:Users')->findOneBy(['name' => $data['authorName']]);
            $message = new Messages();

            if (!$author) {
                return $this->render('forum/category.html.twig', [
                    'category' => $category,
                    'messageCreated' => false,
                    'form' => $form->createView(),
                ]);
            }

            $message->setAuthor($author);
            $message->setText($data['text']);
            $message->setCategory($category);
            $message->setPostedAt(new \DateTime(date('m/d/Y h:i:s a', time())));
            $entityManager->persist($message);
            $entityManager->flush();
        }

        $breadcrumbs = $this->get("white_october_breadcrumbs");
        $node = $category;
        while ($node) {
//            dump($node);
            $breadcrumbs->prependItem($node->getCategoryName(), sprintf('/showCategory=%s', $node->getCategoryName()));
            $node = $node->getParent();
        }
        $breadcrumbs->prependItem('Главная', "/");
        dump($breadcrumbs);
//        die;
//        $breadcrumbs = [];
//        $breadcrumb = $category;
//        dump($breadcrumb);
//        while($breadcrumb->getParent() != null) {
//            $breadcrumbs[] = $breadcrumb->getParent()->getCategoryName();
//        }

//        dump($breadcrumbs);

        return $this->render('forum/category.html.twig', [
            'category' => $category,
            'form' => $form->createView(),
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
}