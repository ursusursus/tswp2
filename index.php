<?php
require 'Slim/Slim.php';

\Slim\Slim::registerAutoloader ();
$app = new \Slim\Slim ();

$app->get("/", function () use($app) {
	echo "hello world";
});

$app->post("/login", function () use($app) {
	echo "login";
});


$app->post("/logout", function () use($app) {
	echo "logout";
});

//
$app->run ();

function getDatabase() {
	$config = include ("config.php");
	$hostname = $config ["hostname"];
	$dbname = $config ["dbname"];
	$username = $config ["username"];
	$password = $config ["password"];
	
	$pdo = new PDO ( "mysql:host=$hostname;dbname=$dbname", $username, $password );
	return $pdo;
}
