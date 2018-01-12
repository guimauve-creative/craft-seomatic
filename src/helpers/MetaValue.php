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

namespace nystudio107\seomatic\helpers;

use craft\elements\Asset;
use nystudio107\seomatic\Seomatic;

use Craft;
use craft\base\Component;
use craft\base\Element;
use craft\elements\Category;
use craft\elements\Entry;
use craft\helpers\StringHelper;
use craft\web\View;

/**
 * @author    nystudio107
 * @package   Seomatic
 * @since     3.0.0
 */
class MetaValue
{
    // Constants
    // =========================================================================

    const MAX_PARSE_TRIES = 5;

    // Static Properties
    // =========================================================================

    /**
     * @var array
     */
    public static $templateObjectVars;

    /**
     * @var View
     */
    public static $view;

    // Static Methods
    // =========================================================================

    /**
     * @param string $metaValue
     *
     * @return string
     */
    public static function parseString($metaValue)
    {
        // Handle being passed in a string
        if (is_string($metaValue)) {
            // If there are no dynamic tags, just return the template
            if (!StringHelper::contains($metaValue, '{')) {
                return $metaValue;
            }
            try {
                $metaValue = self::$view->renderObjectTemplate($metaValue, self::$templateObjectVars);
            } catch (\Exception $e) {
                $metaValue = Craft::t(
                    'seomatic',
                    'Error rendering `{template}` -> {error}',
                    ['template' => $metaValue, 'error' => $e->getMessage()]
                );
                Craft::error($metaValue, __METHOD__);
            }
        }
        // Handle being passed in an object
        if (is_object($metaValue)) {
            if ($metaValue instanceof Asset) {
                /** @var Asset $metaValue */
                return $metaValue->uri;
            }
            return strval($metaValue);
        }
        // Handle being passed in an array
        if (is_array($metaValue)) {
            return implode(' ', $metaValue);
        }

        return $metaValue;
    }

    /**
     * @param array $metaArray
     */
    public static function parseArray(array &$metaArray)
    {
        foreach ($metaArray as $key => $value) {
            if ($value !== null && is_string($value)) {
                $newValue = '';
                // Parse it repeatedly until it doesn't change
                $tries = self::MAX_PARSE_TRIES;
                while ($newValue != $value && $tries) {
                    $tries--;
                    $value = $metaArray[$key];
                    $metaArray[$key] = self::parseString($value);
                    $newValue = $metaArray[$key];
                }
            }
        }

        $metaArray = array_filter($metaArray);
    }

    /**
     * Get the language from a siteId
     *
     * @param int $siteId
     *
     * @return string
     */
    public static function getSiteLanguage(int $siteId): string
    {
        $site = Craft::$app->getSites()->getSiteById($siteId);
        if ($site) {
            $language = $site->language;
        } else {
            $language = Craft::$app->language;
        }
        $language = strtolower($language);
        $language = str_replace('_', '-', $language);

        return $language;
    }

    /**
     * Cache frequently accessed properties locally
     */
    public static function cache()
    {
        self::$templateObjectVars = [
            'seomatic' => Seomatic::$seomaticVariable,
        ];

        $element = Seomatic::$matchedElement;
        /** @var Element $element */
        if (!empty($element)) {
            $reflector = new \ReflectionClass($element);
            $matchedElementType = strtolower($reflector->getShortName());
            self::$templateObjectVars[$matchedElementType] = $element;
        }

        self::$view = Seomatic::$view;
    }
}
