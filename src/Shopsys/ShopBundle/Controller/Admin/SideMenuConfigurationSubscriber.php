<?php

namespace Shopsys\ShopBundle\Controller\Admin;

use Shopsys\FrameworkBundle\Model\AdminNavigation\ConfigureMenuEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class SideMenuConfigurationSubscriber implements EventSubscriberInterface
{
    public static function getSubscribedEvents(): array
    {
        return [ConfigureMenuEvent::SIDE_MENU_DASHBOARD => 'configureDashboardMenu'];
    }

    public function configureDashboardMenu(ConfigureMenuEvent $event): void
    {
        $dashboardMenu = $event->getMenu();

        $dashboardMenu->addChild('my_wahtever', ['route' => 'admin_staticblock_list', 'label' => t('My new action')]);

    }

}