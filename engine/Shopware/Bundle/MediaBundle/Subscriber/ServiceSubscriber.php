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

namespace Shopware\Bundle\MediaBundle\Subscriber;

use Doctrine\Common\Collections\ArrayCollection;
use Enlight\Event\SubscriberInterface;
use Shopware\Bundle\MediaBundle\Commands\MediaCleanupCommand;

class ServiceSubscriber implements SubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Shopware_Console_Add_Command' => 'addCommands',
            'Shopware_CronJob_MediaCrawler' => 'runCronjob'
        ];
    }

    /**
     * @return ArrayCollection
     */
    public function addCommands()
    {
        return new ArrayCollection([
            new MediaCleanupCommand()
        ]);
    }

    /**
     * @return bool
     * @throws \Exception
     */
    public function runCronjob()
    {
        $garbageCollector = Shopware()->Container()->get('shopware_media.garbage_collector');
        $garbageCollector->run();

        return true;
    }
}
