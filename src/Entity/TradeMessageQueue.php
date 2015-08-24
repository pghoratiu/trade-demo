<?php

namespace MyCode\Entity;

use Spot\EntityInterface as Entity;
use Spot\MapperInterface as Mapper;

class TradeMessageQueue extends \Spot\Entity
{
    protected static $table = 'trade_message_queue';
    protected static $mapper = 'MyCode\Entity\Mapper\TradeMessageQueue';

    public static function fields()
    {
        return [
            'id'           => ['type' => 'guid', 'primary' => true],
            'body'         => ['type' => 'text', 'required' => true],
            'status'       => ['type' => 'integer', 'default' => 0, 'index' => true],
            'date_created' => ['type' => 'datetime', 'value' => new \DateTime()]
        ];
    }
}