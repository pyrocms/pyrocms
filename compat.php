<?php

$phpVersion = '5.3.9';

function isPhpOk($expectedVersion)
{
    // Is this version of PHP greater than minimum version required?
    return version_compare(PHP_VERSION, $expectedVersion, '>=');
}

function isDatabaseDriverOk()
{
    return extension_loaded('mysql') or extension_loaded('mysqli');
}

function isZlibOk()
{
    return extension_loaded('zlib');
}

function isCurlOk()
{
    return extension_loaded('curl');
}

function isMcryptOk()
{
    return extension_loaded('mcrypt');
}

function isGdOk()
{
    // Homeboy is not rockin GD at all
    if (! function_exists('gd_info')) {
        return false;
    }

    $gd_info = gd_info();
    $gd_version = preg_replace('/[^0-9\.]/', '', $gd_info['GD Version']);

    // If the GD version is at least 1.0
    return ($gd_version >= 1);
}

echo "<pre>\n";

if ($php = isPhpOk($phpVersion)) {
    echo "PHP is ok\n";
} else {
    echo "PHP is NOT ok\n";
}

if ($databaseDriver = isDatabaseDriverOk()) {
    echo "DatabaseDriver is ok\n";
} else {
    echo "DatabaseDriver is NOT ok\n";
}

if ($zlib = isZlibOk()) {
    echo "Zlib is ok\n";
} else {
    echo "Zlib is NOT ok\n";
}

if ($curl = isCurlOk()) {
    echo "Curl is ok\n";
} else {
    echo "Curl is NOT ok\n";
}

if ($mcrypt = isMcryptOk()) {
    echo "Mcrypt is ok\n";
} else {
    echo "Mcrypt is NOT ok\n";
}

if ($gd = isGdOk()) {
    echo "Gd is ok\n";
} else {
    echo "Gd is NOT ok\n";
}

if ($php && $databaseDriver && $zlib && $curl && $mcrypt && $gd) {
    echo "PyroCMS has everything is needs!!\n";
    echo "</pre>";
    exit(0);
} else {
    echo "PyroCMS DOES NOT have everything it needs. Please contact your system administrator.\n";
    echo "</pre>\n";
    exit(1);
}
