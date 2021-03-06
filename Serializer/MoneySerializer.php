<?php
/**
 * Author: Till Wegmüller
 * Date: 3/17/15
 * Dime
 */

namespace Tbbc\MoneyBundle\Serializer;


use JMS\Serializer\Context;
use JMS\Serializer\GraphNavigator;
use JMS\Serializer\Handler\SubscribingHandlerInterface;
use JMS\Serializer\VisitorInterface;
use JMS\Serializer\XmlSerializationVisitor;
use Money\Money;

class MoneySerializer implements SubscribingHandlerInterface
{

	/**
	 * Return format:
	 *
	 *      array(
	 *          array(
	 *              'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
	 *              'format' => 'json',
	 *              'type' => 'DateTime',
	 *              'method' => 'serializeDateTimeToJson',
	 *          ),
	 *      )
	 *
	 * The direction and method keys can be omitted.
	 *
	 * @return array
	 */
	public static function getSubscribingMethods()
	{
		return array(
			array(
				'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
				'type' => 'Money',
				'format' => 'json',
				'method' => 'serializeMoney',
			),
			array(
				'direction' => GraphNavigator::DIRECTION_SERIALIZATION,
				'type' => 'Money\Money',
				'format' => 'json',
				'method' => 'serializeMoney',
			)
		);
	}

	public function serializeMoney(VisitorInterface $visitor, Money $money, array $type, Context $context)
	{
		return $visitor->visitString(number_format(($money->getAmount()) / 100, 2, '.', ""), $type, $context);
	}
}
