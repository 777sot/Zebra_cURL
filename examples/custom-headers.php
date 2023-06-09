<?php

// make sure error reporting is on
ini_set('display_errors', 1);
error_reporting(E_ALL);

// make sure cache folder exists and is writable
if (!is_dir('cache') || !is_writable('cache')) trigger_error('the "cache" folder must be present and be writable in the "examples" folder', E_USER_ERROR);

// make sure CA bundle exists
elseif (!file_exists('cacert.pem')) trigger_error('"cacert.pem" file was not found', E_USER_ERROR);

// include the library
require '../Zebra_cURL.php';

// instantiate the Zebra_cURL class
$curl = new Zebra_cURL();

// since we are communicating over HTTPS, we load the CA bundle from the examples folder,
// so we don't get CURLE_SSL_CACERT response from cURL
// you can always update this bundle from https://curl.se/docs/caextract.html
$curl->ssl(true, 2, __DIR__ . '/cacert.pem');

// set custom HTTP headers
$curl->option(CURLOPT_HTTPHEADER, [
    'accept: application/json',
    'X-Token-Foo-Bar: ABC123'   // Pass keys to APIs, for example
]);

echo '<pre>';
echo $curl->scrap('http://httpbin.org/get') . PHP_EOL;
