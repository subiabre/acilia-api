<?php

namespace App\Controller;

use App\Component\ApiResponse;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Util\RepositoryNormalizer;
use App\Util\ValidationErrors;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class CategoriesController extends AbstractController
{
    /**
     * @Route("/categories", name="Category:new", methods={"POST"})
     */
    public function c(
        Request $request,
        ApiResponse $response,
        EntityManagerInterface $em, 
        ValidatorInterface $validator,
        ValidationErrors $validationErrors,
        NormalizerInterface $normalizer
    )
    {
        $category = new Category;
        $requestBody = $request->request;

        $category
            ->setName($requestBody->get('name'))
            ->setDescription($requestBody->get('description'));

        $errors = $validator->validate($category);

        if (\count($errors) > 0) {
            $errorList = $validationErrors->list($errors);

            return $response->error('Malformed payload', $errorList);
        }

        $em->persist($category);
        $em->flush();

        $categoryData = $normalizer->normalize($category);
        
        return $response->data(['category' => $categoryData], ApiResponse::HTTP_CREATED);
    }

    /**
     * @Route("/categories/{id}", name="Category:select", methods={"GET"})
     */
    public function r(
        String $id,
        ApiResponse $response,
        NormalizerInterface $normalizer,
        CategoryRepository $categories
    )
    {
        $category = $categories->find($id);

        if (!$category) {
            return $response->error404('category', $id);
        }

        $categoryData = $normalizer->normalize($category);

        return $response->data(['category' => $categoryData]);
    }

    /**
     * @Route("/categories", name="Category:list", methods={"GET"})
     */
    public function rAll(
        ApiResponse $response,
        RepositoryNormalizer $repositoryNormalizer,
        CategoryRepository $categories
    )
    {
        $categoryList = $categories->findAll();
        $allCategories = $repositoryNormalizer->list($categoryList);

        return $response->data(['categories' => $allCategories]);
    }

    /**
     * @Route("/categories/{id}", name="Category:update", methods={"PUT"})
     */
    public function u(
        String $id,
        Request $request,
        ApiResponse $response,
        EntityManagerInterface $em,
        ValidatorInterface $validator,
        ValidationErrors $validationErrors,
        NormalizerInterface $normalizer,
        CategoryRepository $categories
    )
    {
        $category = $categories->find($id);
        $requestBody = $request->request;

        if (!$category) {
            return $response->error404('category', $id);
        }

        $category
            ->setName($requestBody->get('name'))
            ->setDescription($requestBody->get('description'));

        $errors = $validator->validate($category);

        if (\count($errors) > 0) {
            $errorList = $validationErrors->list($errors);

            return $response->error('Malformed payload', $errorList);
        }

        $em->persist($category);
        $em->flush();

        $categoryData = $normalizer->normalize($category);
        
        return $response->data(['category' => $categoryData]);
    }

    /**
     * @Route("/categories/{id}", name="Category:remove", methods={"DELETE"})
     */
    public function d(
        String $id,
        ApiResponse $response,
        EntityManagerInterface $em,
        CategoryRepository $categories
    )
    {
        $category = $categories->find($id);

        if (!$category) {
            return $response->error404('category', $id);
        }

        $em->remove($category);
        $em->flush();

        return $response->data(['category' => 'Category was successfully deleted']);
    }
}
