<?php

namespace MyCode\Entity\Mapper;

use Spot\Mapper;

class TradeMessageQueue extends Mapper
{
    /**
     * Get 10 most recent posts for display on the sidebar
     *
     * @return \Spot\Query
     */
    public function mostRecentTransactions($limit = 10)
    {
        return $this->select()->order(['date_created' => 'DESC'])
            ->limit($limit);
    }
}