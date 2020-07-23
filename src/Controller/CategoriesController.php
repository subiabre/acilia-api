<?php

namespace App\Controller;

use App\Component\ApiResponse;
use App\Entity\Category;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

function listValidationErrors($errors)
{
    $errorList = [];

    foreach ($errors as $error) {
        $path = $error->getPropertyPath();
        $message = $error->getMessage();

        $errorList[$path] = $message;
    }

    return $errorList;
}

class CategoriesController extends AbstractController
{
    /**
     * @Route("/category", name="Category:new", methods={"POST"})
     */
    public function c(
        Request $request,
        ApiResponse $response,
        EntityManagerInterface $em, 
        ValidatorInterface $validator,
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
            $errorList = listValidationErrors($errors);

            return $response->error('Malformed payload', $errorList);
        }

        $em->persist($category);
        $em->flush();

        $categoryData = $normalizer->normalize($category);
        
        return $response->data(['category' => $categoryData]);
    }
}
