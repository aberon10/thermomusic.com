<?php

namespace App\Libs;

function get_template_head() {
	return "<!DOCTYPE html>
	<html lang='es'>
	<head>
	    <meta charset='UTF-8'>
	    <meta name='viewport' content='width=device-width, initial-scale=1.0'>
	    <meta http-equiv='X-UA-Compatible' content='ie=edge'>
	    <title>".getenv('APP_NAME')."</title>
		<style>
			html {box-sizing: border-box;font-family: Verdana, sans-serif;font-size: 16px;}
			*, *::before, *::after { box-sizing: inherit;font-size: 1rem;margin: 0;padding: 0;color: #444;}
			body {background-color: #fff;	}
			h1 {font-size: 1.6rem; font-weight: 400; color: #1287A8; font-family: Verdana, sans-serif;}
			p {margin-bottom: 1rem; text-align: justify;}
			.link {text-decoration: underline;color: #1287A8;}
			.link:hover {color: #00f0ff;}
			.header {height: 4rem; width: 100%; background: #ececec;}
			.logo {height: 100%;width: 100%;display: flex;align-items: center;text-align: center;padding-left: 2rem;}
			.main-container {width: 80%;margin: 1rem auto; margin-left: 2rem;}
			.footer {text-align: center;display: flex;align-items: center;padding-top: 1rem;}
			.footer p {margin-bottom: 0;font-size: .8rem;}
			.signature {margin-top: 2rem;}
		</style>
	</head>
	<body>";
}

function get_template_header() {
	return "<header class='header'><h1 class='logo'>".getenv('APP_NAME')."</h1></header>";
}

function get_template_footer() {
	return "</body></html>";
}

function get_template_welcome($user, $email, $link) {
	return "<section class='main-container'>
				<p>Hola, <b>".$user."</b></p>
				<p>El equipo de Thermomusic te da la bienvenida y esperamos que disfrutes de nuestro servicio.</p>
				<p>Es necesario que confirmes que la dirección <span class='underline'><b>".$email."</b></span> es tuya.</p>
				<p>Para confirmar tu cuenta de correo haz <a class='link' href='".$link."' target='_blank'>click aquí</a></p>
				<div class='signature'>
					<p>Si tienes alguna duda, contacta a nuestro equipo de soporte o responde a este mismo correo.</p>
					<p>Gracias, El equipo de Thermomusic.</p>
				</div>
				<footer class='footer'>
					<p>". getenv('APP_NAME') ." © 2016 - ".date('Y')."</p>
				</footer>
			</section>";
}