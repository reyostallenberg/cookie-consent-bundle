<?php

declare(strict_types=1);

/*
 * This file is part of the ConnectHolland CookieConsentBundle package.
 * (c) Connect Holland.
 */

namespace ConnectHolland\CookieConsentBundle\DependencyInjection;

use ConnectHolland\CookieConsentBundle\Enum\CategoryEnum;
use ConnectHolland\CookieConsentBundle\Enum\ThemeEnum;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder(): TreeBuilder
    {
        $treeBuilder = new TreeBuilder('ch_cookie_consent');
        
        if (method_exists($treeBuilder, 'getRootNode')) {
            $rootNode = $treeBuilder->getRootNode();
        } else {
            // BC layer for symfony/config 4.1 and older
            $rootNode = $treeBuilder->root('sensio_framework_extra');
        }

        $rootNode
            ->children()
                ->variableNode('categories')
                    ->defaultValue([CategoryEnum::CATEGORY_TRACKING, CategoryEnum::CATEGORY_MARKETING, CategoryEnum::CATEGORY_SOCIAL_MEDIA])
                ->end()
                ->enumNode('theme')
                    ->defaultValue(ThemeEnum::THEME_LIGHT)
                    ->values(ThemeEnum::getAvailableThemes())
                ->end()
                ->booleanNode('use_logger')
                    ->defaultTrue()
                ->end()
            ->end()
        ;

        return $treeBuilder;
    }
}
