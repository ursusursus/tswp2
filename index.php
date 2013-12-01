<?php

//////////// SETUPOVACKY ///////////////////
session_start();

require "Slim/Slim.php";
\Slim\Slim::registerAutoloader();

$app = new \Slim\Slim();

define("HOME", "/tswp2");
define("FIRST_PAGE", HOME . "/page/1");
define("LOGIN_PAGE", HOME . "/login");

//////////// ROUTY //////////////////

/**
* Home
*/
$app->get("/", function() use ($app) {
	checkAuthenticated($app);
	$app->redirect(FIRST_PAGE);
});

/**
* Login
*/
$app->get("/login", function() use ($app) {
	$app->render("login.html");
});

/**
* Logout
*/
$app->post("/logout", function() use ($app) {
	session_destroy();
	$app->redirect(LOGIN_PAGE);
});

/**
* Actual login
*/ 
$app->post("/login", function() use ($app) {
	$request = $app->request();
	$username = $request->post("username");
	$password = $request->post("password");

	if($username == "user" && $password == "password") {
		$_SESSION["user_id"] = "dummy_user_id";
		$app->redirect(FIRST_PAGE);

	} else {
		// $app->flash("error", "Wrong username or password");
		$app->redirect(LOGIN_PAGE);
	}
});

/**
* Get page
*/
$app->get("/page/:page", function($page) use ($app) {
	checkAuthenticated($app);
	$app->render("page.html", array("page" => $page));
});

///////////// HELPERY ///////////////

function getDatabase() {
	$config = include("config.php");
	$hostname = $config["hostname"];
	$dbname = $config["dbname"];
	$username = $config["username"];
	$password = $config["password"];
	
	$pdo = new PDO ( "mysql:host=$hostname;dbname=$dbname", $username, $password );
	return $pdo;
}

function checkAuthenticated($app) {
    if(!isset($_SESSION["user_id"])) {
        $app->redirect(LOGIN_PAGE);
    }
}
//////////////////////////////////////

$app->run ();
