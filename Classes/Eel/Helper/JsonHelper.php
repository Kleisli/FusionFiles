<?php
namespace Kleisli\FusionFiles\Eel\Helper;

/*
 * This file is part of the Neos.Eel package.
 *
 * (c) Contributors of the Neos Project - www.neos.io
 *
 * This package is Open Source Software. For the full copyright and license
 * information, please view the LICENSE file which was distributed with this
 * source code.
 */

use Neos\Flow\Annotations as Flow;
use Neos\Eel\ProtectedContextAwareInterface;

/**
 * JSON helpers for Eel contexts
 *
 * @Flow\Proxy(false)
 */
class JsonHelper implements ProtectedContextAwareInterface
{
    /**
     * JSON encode the given value
     *
     *
     * @param mixed $value
     * @return string
     */
    public function stringify($value): string
    {
        $content = json_encode($value);

        // unescape cache entries
        $cacheEntries = [];
        preg_match_all("$\\\u0002(.*?)\\\u001f(.*?)\\\u001f$", $content, $cacheEntries);
        $cacheEntries = array_merge($cacheEntries[1], $cacheEntries[2]);
        $strippedCacheEntries = [];
        foreach ($cacheEntries as $cacheEntry){
            $strippedCacheEntries[] = stripslashes($cacheEntry);
        }
        $content = str_replace($cacheEntries, $strippedCacheEntries, $content);

        // replace cache markers
        $jsonCacheMarkers = ["\u0002", "\u0003", "\u001f"];
        $asciiCacheMarkers = ["\x02", "\x03", "\x1f"];

        return str_replace($jsonCacheMarkers, $asciiCacheMarkers, $content);
    }

    /**
     * JSON decode the given string
     *
     * @param string $json
     * @param boolean $associativeArrays
     * @return mixed
     */
    public function parse($json, $associativeArrays = true)
    {
        return json_decode($json, $associativeArrays);
    }

    /**
     * All methods are considered safe
     *
     * @param string $methodName
     * @return boolean
     */
    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
