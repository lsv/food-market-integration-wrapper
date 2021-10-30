<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegrationTest\Request;

use DateTime;
use Lsv\FoodMarketIntegration\Request\GetSellingPointMenus;
use Lsv\FoodMarketIntegration\Response\Menu\Product;
use Symfony\Component\HttpClient\Response\MockResponse;

class GetSellingPointMenusTest extends AbstractRequestTest
{
    private const MARKET_ID = '123';
    private const SELLING_POINT = 321;

    private GetSellingPointMenus $testObject;

    protected function setUp(): void
    {
        $this->testObject = new GetSellingPointMenus(self::MARKET_ID, self::SELLING_POINT);
    }

    public function testCanSetOptionals(): void
    {
        $responses = [
            new MockResponse(file_get_contents(__DIR__.'/responses/get_selling_point_menus.json')),
        ];
        self::setRequest($responses);

        $date = new DateTime('2021-12-15');
        $this->testObject->setDate($date);
        $this->testObject->setOrderType('order');
        $this->testObject->request();
        self::assertSame(
            '/markets/123/sellingPoints/321/menus?date=2021-12-15&orderType=order',
            $this->testObject->getRequestUrl()
        );
    }

    public function testCanGetResponse(): void
    {
        $responses = [
            new MockResponse(file_get_contents(__DIR__.'/responses/get_selling_point_menus.json')),
        ];
        self::setRequest($responses);

        $data = $this->testObject->request();
        self::assertSame(
            '/markets/123/sellingPoints/321/menus',
            $this->testObject->getRequestUrl()
        );

        self::assertCount(1, $data);
        $menu = $data[0];
        self::assertSame(10674, $menu->id);
        self::assertSame('2020-07-23', $menu->availableFrom->format('Y-m-d'));
        self::assertNull($menu->availableTo);
        self::assertSame('Nuestra carta de pizzas', $menu->shortDescription);
        self::assertCount(3, $menu->menuSections);
        self::assertSame(8398, $menu->menuSections[0]->id);
        self::assertCount(2, $menu->menuSections[0]->products);
        $product = $menu->menuSections[0]->products[0];
        self::assertInstanceOf(Product::class, $product);
        self::assertCount(1, $product->productOptionsCategories);
        self::assertSame(13327, $product->productOptionsCategories[0]->id);
        self::assertCount(4, $menu->allowedOrderTypes);
        self::assertSame(1193, $menu->schedule->id);
    }
}
