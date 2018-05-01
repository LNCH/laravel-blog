<?php

// Get active site model
function getBlogSiteID()
{
    $siteClass = config("laravel-blog.site_model");
    $siteClassInstance = $siteClass
        ? new $siteClass()
        : null;

    return $siteClassInstance ? $siteClassInstance::getSiteId() : null;
}

function blogUrl($url)
{
    $routePrefix = config("laravel-blog.route_prefix", "");
    if ($routePrefix && substr($routePrefix, -1) !== "/") {
        $routePrefix .= "/";
    }

    return url($routePrefix.$url);
}