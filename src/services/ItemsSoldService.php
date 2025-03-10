<?php

/**
 * Commerce Reports Items Sold Service
 *
 * @link      https://fostercommerce.com
 * @copyright Copyright (c) 2021 Foster Commerce
 */

declare(strict_types=1);

namespace fostercommerce\commercereports\services;

use craft\base\Component;
use fostercommerce\commercereports\CommerceReports;

use fostercommerce\commercereports\models\ItemSoldModel;

class ItemsSoldService extends Component
{
    /**
     * Constructor. Fetches the items sold data when the class is instantiated.
     *
     * @return void
     */
    public function __construct($config = [])
    {
        parent::__construct($config);
    }

    /**
     * Fetches the items sold based on the given criteria established in the constructor.
     *
     * @return array
     */
    private function fetchItemsSold(): array
    {
        $orders = CommerceReports::$plugin->orders->fetchOrders(['withPrevious' => false]);
        $results = ItemSoldModel::fromArrayedOrders($orders);

        usort($results, function($a, $b) {
            return $b['totalSold'] <=> $a['totalSold'];
        });

        return $results;
    }

    /**
     * Returns the items sold.
     *
     * @return array
     */
    public function getItemsSold(): array
    {
        return $this->fetchItemsSold();
    }
}
