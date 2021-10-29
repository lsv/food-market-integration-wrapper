<?php

declare(strict_types=1);

namespace Lsv\FoodMarketIntegration\Response\Order;

class Consumer
{
    public int $id;
    public string $name;
    public string $lastname;
    public ?string $email;
    public string $phone;
    public ?string $image;
    public string $notificationsChannel;
    public ?string $chatToken;
    public ?int $marketClientId;
}
