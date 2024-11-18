<?php

function getFullUrl()
{
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";
    $host = $_SERVER['HTTP_HOST'];
    $requestUri = $_SERVER['REQUEST_URI'];

    return $protocol . $host . $requestUri;
}

function isActivePage($url)
{
    if (strpos(getFullUrl(), $url) !== false) return 'active';
    else return 'not-active';
}
