<?php
/**
 * SEOmatic plugin for Craft CMS 3.x
 *
 * A turnkey SEO implementation for Craft CMS that is comprehensive, powerful,
 * and flexible
 *
 * @link      https://nystudio107.com
 * @copyright Copyright (c) 2017 nystudio107
 */

/**
 * @author    nystudio107
 * @package   Seomatic
 * @since     3.0.0
 */

return [
    '*' => [
        'siteType'                      => 'Product',
        'siteSubType'                   => '',
        'siteSpecificType'              => '',

        'seoTitleSource'                => 'fromField',
        'seoTitleField'                 => 'title',
        'siteNamePositionSource'        => 'sameAsGlobal',
        'seoDescriptionSource'          => 'fromCustom',
        'seoDescriptionField'           => '',
        'seoKeywordsSource'             => 'fromCustom',
        'seoKeywordsField'              => '',
        'seoImageIds'                   => [],
        'seoImageSource'                => 'fromCustom',
        'seoImageField'                 => '{{ product.images[0].src ?? ""}}',
        'seoImageTransform'             => false,
        'seoImageTransformMode'         => 'crop',
        'seoImageDescriptionSource'     => 'fromCustom',
        'seoImageDescriptionField'      => '',

        'twitterCreatorSource'          => 'sameAsSite',
        'twitterCreatorField'           => '',
        'twitterTitleSource'            => 'sameAsSeo',
        'twitterTitleField'             => '',
        'twitterSiteNamePositionSource' => 'sameAsGlobal',
        'twitterDescriptionSource'      => 'sameAsSeo',
        'twitterDescriptionField'       => '',
        'twitterImageIds'               => [],
        'twitterImageSource'            => 'sameAsSeo',
        'twitterImageField'             => '',
        'twitterImageTransform'         => true,
        'twitterImageTransformMode'     => 'crop',
        'twitterImageDescriptionSource' => 'sameAsSeo',
        'twitterImageDescriptionField'  => '',

        'ogTitleSource'                 => 'sameAsSeo',
        'ogTitleField'                  => '',
        'ogSiteNamePositionSource'      => 'sameAsGlobal',
        'ogDescriptionSource'           => 'sameAsSeo',
        'ogDescriptionField'            => '',
        'ogImageIds'                    => [],
        'ogImageSource'                 => 'sameAsSeo',
        'ogImageField'                  => '',
        'ogImageTransform'              => true,
        'ogImageTransformMode'          => 'crop',
        'ogImageDescriptionSource'      => 'sameAsSeo',
        'ogImageDescriptionField'       => '',
    ],
];
