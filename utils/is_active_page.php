<?php

function getFullUrl()
{
    $is_https = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443);
    $protocol = $is_https ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'] . ($is_https ? '' : ':' . $_SERVER['SERVER_PORT']);;
    $requestUri = $_SERVER['REQUEST_URI'];

    return $protocol . $host . $requestUri;
}

function isActivePage($url)
{
    $full_url = getFullUrl();
    if (strpos($full_url, $url) !== false) return 'active';
    else return 'not-active';
}
