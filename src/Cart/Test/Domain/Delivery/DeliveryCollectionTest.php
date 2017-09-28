<?php
/**
 * Shopware 5
 * Copyright (c) shopware AG
 *
 * According to our dual licensing model, this program can be used either
 * under the terms of the GNU Affero General Public License, version 3,
 * or under a proprietary license.
 *
 * The texts of the GNU Affero General Public License with an additional
 * permission and of our proprietary license can be found at and
 * in the LICENSE file you have received along with this program.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Affero General Public License for more details.
 *
 * "Shopware" is a registered trademark of shopware AG.
 * The licensing of the program under the AGPLv3 does not imply a
 * trademark license. Therefore any rights, title and interest in
 * our trademarks remain entirely with us.
 */

namespace Shopware\Cart\Test\Domain\Delivery;

use PHPUnit\Framework\TestCase;
use Shopware\AreaCountry\Struct\AreaCountryBasicStruct;
use Shopware\Cart\Delivery\Delivery;
use Shopware\Cart\Delivery\DeliveryCalculator;
use Shopware\Cart\Delivery\DeliveryCollection;
use Shopware\Cart\Delivery\DeliveryDate;
use Shopware\Cart\Delivery\DeliveryPositionCollection;
use Shopware\Cart\Delivery\ShippingLocation;
use Shopware\Cart\Price\Price;
use Shopware\Cart\Tax\CalculatedTaxCollection;
use Shopware\Cart\Tax\TaxRuleCollection;
use Shopware\ShippingMethod\Struct\ShippingMethodBasicStruct;

class DeliveryCollectionTest extends TestCase
{
    public function testCollectionIsCountable(): void
    {
        $collection = new DeliveryCollection();
        static::assertCount(0, $collection);
        static::assertSame(0, $collection->count());
    }

    public function testAddFunctionAddsANewDelivery(): void
    {
        $collection = new DeliveryCollection();
        $collection->add(
            new Delivery(
                new DeliveryPositionCollection(),
                new DeliveryDate(
                    new \DateTime(),
                    new \DateTime()
                ),
                new ShippingMethodBasicStruct(1, '', DeliveryCalculator::CALCULATION_BY_WEIGHT, true, 1),
                self::createShippingLocation(),
                new Price(0, 0, new CalculatedTaxCollection(), new TaxRuleCollection())
            )
        );
        static::assertCount(1, $collection);
    }

    public function testCollectionCanBeFilledByConstructor(): void
    {
        $collection = new DeliveryCollection([
            new Delivery(
                new DeliveryPositionCollection(),
                new DeliveryDate(
                    new \DateTime(),
                    new \DateTime()
                ),
                new ShippingMethodBasicStruct(1, '', DeliveryCalculator::CALCULATION_BY_WEIGHT, true, 1),
                self::createShippingLocation(),
                new Price(0, 0, new CalculatedTaxCollection(), new TaxRuleCollection())
            ),
            new Delivery(
                new DeliveryPositionCollection(),
                new DeliveryDate(
                    new \DateTime(),
                    new \DateTime()
                ),
                new ShippingMethodBasicStruct(1, '', DeliveryCalculator::CALCULATION_BY_WEIGHT, true, 1),
                self::createShippingLocation(),
                new Price(0, 0, new CalculatedTaxCollection(), new TaxRuleCollection())
            ),
        ]);
        static::assertCount(2, $collection);
    }

    public function testCollectionCanBeCleared(): void
    {
        $collection = new DeliveryCollection([
            new Delivery(
                new DeliveryPositionCollection(),
                new DeliveryDate(
                    new \DateTime(),
                    new \DateTime()
                ),
                new ShippingMethodBasicStruct(1, '', DeliveryCalculator::CALCULATION_BY_WEIGHT, true, 1),
                self::createShippingLocation(),
                new Price(0, 0, new CalculatedTaxCollection(), new TaxRuleCollection())
            ),
            new Delivery(
                new DeliveryPositionCollection(),
                new DeliveryDate(
                    new \DateTime(),
                    new \DateTime()
                ),
                new ShippingMethodBasicStruct(1, '', DeliveryCalculator::CALCULATION_BY_WEIGHT, true, 1),
                self::createShippingLocation(),
                new Price(0, 0, new CalculatedTaxCollection(), new TaxRuleCollection())
            ),
        ]);
        $collection->clear();
        static::assertCount(0, $collection);
    }

    private static function createShippingLocation(): ShippingLocation
    {
        $country = new AreaCountryBasicStruct();
        $country->setAreaUuid('SWAG-AREA-UUID-1');

        return \Shopware\Cart\Delivery\ShippingLocation::createFromCountry($country);
    }
}