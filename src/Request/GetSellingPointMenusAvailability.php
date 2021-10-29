<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Request;

use Symfony\Component\OptionsResolver\OptionsResolver;

class GetSellingPointMenusAvailability extends GetSellingPointMenus
{
    private const LOAD_PRODUCTS = 'loadProducts';

    public function setLoadProducts(bool $loadProducts = true): void
    {
        $this->addQueryData(self::LOAD_PRODUCTS, $loadProducts);
    }

    protected function getUrlQuery(): array
    {
        $data = parent::getUrlQuery();
        if (null !== ($loadProducts = $this->getQueryData(self::LOAD_PRODUCTS))) {
            $data['loadProducts'] = $loadProducts;
        }

        return $data;
    }

    protected function resolveQueryData(OptionsResolver $resolver): void
    {
        parent::resolveQueryData($resolver);
        $resolver->setDefined([self::LOAD_PRODUCTS]);
    }
}
