<?php

namespace App\Util;

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

    public function __construct(NormalizerInterface $normalizer)
    {
        $this->normalizer = $normalizer;
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
}
