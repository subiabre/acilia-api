<?php

namespace App\Util;

use App\Repository\CategoryRepository;
use App\Service\CurrencyConverter;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * Normalizes a repository list
 */
class RepositoryNormalizer
{
    /**
     * @var Normalizer
     */
    private $normalizer;

    /**
     * @var CurrencyConverter
     */
    private $currencyConverter;

    /**
     * @var CategoryRepository
     */

    public function __construct(
        NormalizerInterface $normalizer, 
        CurrencyConverter $currencyConverter,
        CategoryRepository $categories
    )
    {
        $this->normalizer = $normalizer;
        $this->currencyConverter = $currencyConverter;
        $this->categories = $categories;
    }

    /**
     * Normalize each element inside a repository list
     * @param array $repositoryList An array of elements from a repository search
     * @return array
     */
    public function list($repositoryList): array
    {
        $allProducts = [];
        
        foreach ($repositoryList as $product) {
            $productData = $this->normalizer->normalize($product);

            \array_push($allProducts, $productData);
        }

        return $allProducts;
    }

    /**
     * Normalize elements inside the repository list with converted currency values
     * @param array $repositoryList An array of elements from a repository search
     * @param string $currency Currency to convert to
     * @return array
     */
    public function currencyConvert(array $featured, string $currency): array
    {
        $allProducts = [];

        foreach ($featured as $key => $product) {
            if ($product->getCurrency() !== $currency) {
                $price = $this->currencyConverter
                    ->from($product->getPrice(), $product->getCurrency())
                    ->to($currency)
                    ->getValues();

                $product
                    ->setCurrency($currency)
                    ->setPrice($price[$currency]);
            }

            $allProducts[$key] = $product;
        }

        return $this->list($allProducts);
    }

    /**
     * Normalize product list with category name instead of category id
     * @param array $productList
     * @return array
     */
    public function categoryName(array $productList): array
    {
        $allProducts = [];

        foreach ($productList as $product) {
            $id = $product->getCategory() ?: 0;
            $category = $this->categories->find($id);

            if ($category) {
                $product->setCategory($category->getName());
            }

            \array_push($allProducts, $product);
        }

        return $this->list($allProducts);
    }
}
