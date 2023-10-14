<?php

namespace App\Form\Handler;

use App\Entity\Order;
use App\Utils\Manager\OrderManager;

class OrderFormHandler
{
	/**
	 * @var OrderManager
	 */
	private $orderManager;

	public function __construct(OrderManager $orderManager)
	{
		$this->orderManager = $orderManager;
	}

	public function getOrder(?int $idOrder)
	{
		if ($idOrder) {
			$order = $this->orderManager->getRepository()->find($idOrder);
		} else {
			$order = new Order();
		}

		return $order;
	}

	/**
	 * @param Order $order
	 * @return Order|null
	 */
	public function processEditForm(Order $order)
	{
		$this->orderManager->save($order);

		return $order;
	}
}
