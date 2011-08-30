<?php

// The purpose of this central config file is configuring all examples
// in one place with minimal work for your working environment

$phpcas_path = '../../source/';

///////////////////////////////////////
// Basic Config of the phpCAS client //
///////////////////////////////////////

// Full Hostname of your CAS Server
$cas_host = 'cas.example.com';

// Context of the CAS Server
$cas_context = '/cas-server';

// Port of your CAS server. Normally for a https server it's 443
$cas_port = 443;

// Path to the ca chain that issued the cas server certificate
$cas_server_ca_cert_path = '/path/to/cachain.pem';

//////////////////////////////////////////
// Advanced Config for special purposes //
//////////////////////////////////////////

// The "real" hosts of clustered cas server that send SAML logout messages
// Assumes the cas server is load balanced across multiple hosts
$cas_real_hosts = array (
	'cas-real-1.example.com',
	'cas-real-2.example.com'
);

// Generating the URLS for the local cas example services for proxy testing
$curbase = 'http://'.$_SERVER['SERVER_NAME'];
if ($_SERVER['SERVER_PORT'] != 80)
	$curbase .= ':'.$_SERVER['SERVER_PORT'];

$curdir = dirname($_SERVER['REQUEST_URI'])."/";

// CAS client nodes for rebroadcasting pgtIou/pgtId and logoutRequest
$rebroadcast_node_1 = 'http://cas-client-1.example.com';
$rebroadcast_node_2 = 'http://cas-client-2.example.com';

// access to a single service
$serviceUrl = $curbase.$curdir.'/example_service.php';
// access to a second service
$serviceUrl2 = $curbase.$curdir.'example_service_that_proxies.php';

$cas_url = 'https://'.$cas_host;
if ($cas_port != '443')
{
	$cas_url = $cas_url.':'.$cas_port;
}
$cas_url = $cas_url.$cas_context;


// Set the session-name to be unique to the current script so that the client script
// doesn't share its session with a proxied script.
// This is just useful when running the example code, but not normally.
session_name('session_for:'.preg_replace('/[^a-z0-9-]/i', '_', basename($_SERVER['SCRIPT_NAME'])));
?>
