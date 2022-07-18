<?php

use RalphJSmit\Laravel\SEO\Models\SEO;

return [
    /**
     * The SEO model. You can use this setting to override the model used by the package.
     * Make sure to always extend the old model, so that you'll not lose functionality during upgrades.
     */
    'model' => SEO::class,
    'site_name' => "Developer news daily",
    'sitemap' => null,
    'canonical_link' => true,
    'favicon' => null,
    'title' => [
        'infer_title_from_url' => true,
        'suffix' => ' - your daily development news',
        'homepage_title' => "Your daily development news",
    ],

    'description' => [
        /**
         * Use this setting to specify a fallback description, which will be used on places
         * where we don't have a description set via an associated ->seo model or via
         * the ->getDynamicSEOData() method.
         */
        'fallback' => null,
    ],

    'image' => [
        'fallback' => null,
    ],

    'author' => [
        'fallback' => "LzoMedia",
    ],

    'twitter' => [
        '@username' => "L70Media",
    ],
];
