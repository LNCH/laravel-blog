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