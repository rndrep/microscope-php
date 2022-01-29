<?php

namespace App\Classes;

class YoutubeUrl
{
    const EMBED_URL = 'https://www.youtube.com/embed/';
    const DISABLE_SIMILAR_VIDEO = '?rel=0';

    /**
     * Gets user-defined URL and returns embed URL
     */
    public static function getUrl(string $url): string
    {

        $uid = self::getVideoUID($url);
        return empty($uid)
            ? ''
            : self::EMBED_URL . $uid . self::DISABLE_SIMILAR_VIDEO;
    }

    /**
     * Gets user-defined URL and returns youtube video ID
     */
    public static function getVideoUID(string $url): string
    {
        $parsed_url = parse_url($url);
        $parsed_query = [];
        $uid = '';

        if (isset($parsed_url['query'])) {
            parse_str($parsed_url['query'], $parsed_query);
            $uid = $parsed_query['v'] ?? '';
        }
        if ($uid || !$parsed_url['path']) {
            return trim($uid);
        }
        $urlArray = explode('/', $parsed_url['path']);
        return trim(array_pop($urlArray));
    }

}
