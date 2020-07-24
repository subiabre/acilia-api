<?php

namespace App\Controller;

use App\Component\ApiResponse;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Util\ValidationErrors;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class ProductsController extends AbstractController
{
    /**
     * @Route("/product", name="Product:new", methods={"POST"})
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
        $product = new Product;
        $requestBody = $request->request;
        $isFeatured = ($requestBody->get('featured', '') == 'true') ? true : false;

        $product
            ->setName($requestBody->get('name', ''))
            ->setCategory($requestBody->get('category'))
            ->setPrice($requestBody->get('price', 0))
            ->setCurrency($requestBody->get('currency', ''))
            ->setFeatured($isFeatured);

        $errors = $validator->validate($product);

        if (\count($errors) > 0) {
            $errorList = $validationErrors->list($errors);

            return $response->error('Malformed payload', $errorList);
        }

        $em->persist($product);
        $em->flush();

        $productData = $normalizer->normalize($product);

        return $response->data(['product' => $productData], ApiResponse::HTTP_CREATED);
    }

    /**
     * @Route("/products", name="Product:list", methods={"GET"})
     */
    public function r(
        ApiResponse $response,
        NormalizerInterface $normalizer,
        ProductRepository $products
    )
    {
        $productList = $products->findAll();
        $allProducts = [];
        
        foreach ($productList as $product) {
            $productData = $normalizer->normalize($product);

            \array_push($allProducts, $productData);
        }

        return $response->data(['products' => $allProducts]);
    }
}
