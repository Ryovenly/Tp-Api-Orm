<?php

namespace App\Controller;

use App\Entity\Article;
use App\Form\ArticleType;
use App\Repository\ArticleRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class ArticleController extends AbstractbaseController
{

        // Injection de dépendance par constructeur
    private $em;
  
    public function __construct(EntityManagerInterface $em)
    {
      $this->em = $em;
    }
  
  
      
      /**
       * @Route("/article", name="article_list", methods={"GET"})
       */
      public function list(ArticleRepository $articleRepository, SerializerInterface $serializer)
  
      {
          $articles = $articleRepository->findAll();
  
          $jsonarticles = $serializer->serialize($articles, 'json');
  

  
          return new Response(
              $jsonarticles,
              Response::HTTP_OK,
              ['Content-type' => 'application/json']
          );
      }
  
        /**
       * @Route("/article/trending", name="article_trending", methods={"GET"})
       */
      public function listTrending(ArticleRepository $articleRepository, SerializerInterface $serializer)
  
      {
          $articles = $articleRepository->findBy(['trending' => true]);
  
          $jsonarticles = $serializer->serialize($articles, 'json');
  

  
          return new Response(
              $jsonarticles,
              Response::HTTP_OK,
              ['Content-type' => 'application/json']
          );
      }

        /**
       * @Route("/article/category", name="article_category", methods={"GET"})
       */
      public function listByCategory(ArticleRepository $articleRepository, SerializerInterface $serializer)
  
      {
          $articles = $articleRepository->findBy(['category' => 1]);
  
          $jsonarticles = $serializer->serialize($articles, 'json');
  

  
          return new Response(
              $jsonarticles,
              Response::HTTP_OK,
              ['Content-type' => 'application/json']
          );
      }
  
  
    /**
     * @Route("/article/{id}", name="article_detail", methods={"GET"})
     */
      public function detail(Article $article)
      {
        return $this->json(
          ['article' => $article], // données à sérialiser
          Response::HTTP_OK, // Code de réponse HTTP
          [], // En-têtes
          ['groups' => 'article:create'] // Groupes
        );
      }
  
      /**
       * @Route("/article/{id}", name="article_delete", methods= {"DELETE"})
       */

  
      public function delete(Article $article)
      {
        $this->em->remove($article);
        $this->em->flush();
    
        return $this->json('ok');
      }
  
  
      /**
       * @Route("/article", name="article_create", methods= {"POST"})
       */
  
  
    public function create(Request $request, EntityManagerInterface $en) {
          $article = new Article();
          $body = $request->getContent();
          $data = json_decode($body, true);
  
          $form = $this->createForm(ArticleType::class, $article);
  
          $form->submit($data);
  
          
          if ($form->isSubmitted() && $form->isValid()) {
              // On pourrait mettre la date à ce niveau mais on le fait automatiquement avec EventSubscriber
             // $article->setCreated(new DateTime());
              $en->persist($article);
              $en->flush();
              return $this->json($article, Response::HTTP_CREATED,
              [],

             [AbstractNormalizer::IGNORED_ATTRIBUTES => ["created", "visible"]]
          );
      }
          $errors = $this->getFormErrors($form);
          return $this->json(
            $errors,
            Response::HTTP_BAD_REQUEST
          );
    }
    
  
        /**
     * @Route("/article/{id}", name="article_patch", methods={"PATCH"})
     */
    public function patch(Article $article, Request $request)
    {
      return $this->update($request, $article, false);
    }
  
    /**
     * @Route("/article/{id}", name="article_put", methods={"PUT"})
     */
    public function put(Article $article, Request $request)
    {
      return $this->update($request, $article);
    }
  
  
    private function update(
      Request $request,
      Article $article,
      bool $clearMissing = true
    ) {
      $data = json_decode($request->getContent(), true);
      $form = $this->createForm(ArticleType::class, $article);
  
      $form->submit($data, $clearMissing);
  
      if ($form->isSubmitted() && $form->isValid()) {
        $this->em->flush();
  
        return $this->json($article);
      }
  
      $errors = $this->getFormErrors($form);
      return $this->json(
        $errors,
        Response::HTTP_BAD_REQUEST
      );
    }
}
