<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\CategoryType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\AbstractNormalizer;
use Symfony\Component\Serializer\SerializerInterface;

class CategoryController extends AbstractBaseController
{
 
        // Injection de dépendance par constructeur
    private $em;
  
    public function __construct(EntityManagerInterface $em)
    {
      $this->em = $em;
    }
  
  
      
      /**
       * @Route("/category", name="category_list", methods={"GET"})
       */
      public function list(CategoryRepository $categoryRepository, SerializerInterface $serializer)
  
      {
          $categorys = $categoryRepository->findAll();
  
          $jsoncategorys = $serializer->serialize($categorys, 'json');
  

  
          return new Response(
              $jsoncategorys,
              Response::HTTP_OK,
              ['Content-type' => 'application/json']
          );
      }
  
  
    /**
     * @Route("/category/{id}", name="category_detail", methods={"GET"})
     */
      public function detail(Category $category)
      {
        return $this->json(
          ['category' => $category], // données à sérialiser
          Response::HTTP_OK, // Code de réponse HTTP
          [], // En-têtes
          ['groups' => 'category:create'] // Groupes
        );
      }
  
      /**
       * @Route("/category/{id}", name="category_delete", methods= {"DELETE"})
       */

  
      public function delete(Category $category)
      {
        $this->em->remove($category);
        $this->em->flush();
    
        return $this->json('ok');
      }
  
  
      /**
       * @Route("/category", name="category_create", methods= {"POST"})
       */
  
  
    public function create(Request $request, EntityManagerInterface $en) {
          $category = new Category();
          $body = $request->getContent();
          $data = json_decode($body, true);
  
          $form = $this->createForm(CategoryType::class, $category);
  
          $form->submit($data);
  
          
          if ($form->isSubmitted() && $form->isValid()) {
              $en->persist($category);
              $en->flush();
              return $this->json($category, Response::HTTP_CREATED,
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
     * @Route("/category/{id}", name="category_patch", methods={"PATCH"})
     */
    public function patch(Category $category, Request $request)
    {
      return $this->update($request, $category, false);
    }
  
    /**
     * @Route("/category/{id}", name="category_put", methods={"PUT"})
     */
    public function put(Category $category, Request $request)
    {
      return $this->update($request, $category);
    }
  
  
    private function update(
      Request $request,
      Category $category,
      bool $clearMissing = true
    ) {
      $data = json_decode($request->getContent(), true);
      $form = $this->createForm(CategoryType::class, $category);
  
      $form->submit($data, $clearMissing);
  
      if ($form->isSubmitted() && $form->isValid()) {
        $this->em->flush();
  
        return $this->json($category);
      }
  
      $errors = $this->getFormErrors($form);
      return $this->json(
        $errors,
        Response::HTTP_BAD_REQUEST
      );
    }
}
