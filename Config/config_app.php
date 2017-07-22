<?php

/**
 * Configuraciones, rutas de ficheros y restricciones propias de la aplicación.
 *
 * @author Alejandro Beron <alejandroberon10@gmail.com>
 * @version 1.0
 */

const APP_NAME = 'Thermomusic';

const APP_URL = 'http://thermomusic.com/';

// URL donde se guardan los recursos
const SRC_RESOURCES = "http://thermobackend.com/storage/";

const EMAIL_SUPPORT = 'thermoteam2016@gmail.com';

// Servidor SMTP
const SERVER_SMTP = '';

// Planes de pago
const PAYMENT_PLANS = array('5.99');

// Tipos de perfiles de usuario
const USER_PREMIUM     = 3;
const USER_FREE        = 4;
const USER_NO_REGISTER = 5;

// Número de playlist que puede crear cada perfil
const MAX_PLAYLIST_FREE = 10; 
const MAX_PLAYLIST_NR   = 2; 

// Máxima cantidad de pistas por playlist
const MAX_TRACKS_PREMIUM     = 30; 
const MAX_TRACKS_FREE        = 8; 
const MAX_TRACKS_NO_REGISTER = 8; 

// Máxima cantidad de pistas favoritas
const MAX_TRACKS_FAVORITE_FREE = 8; 
const MAX_TRACKS_FAVORITE_NR = 8; 

// Top de canciones
const TOP = 10;

// API GOOGLE
const GO_ID_CLIENT_GOOGLE = '512127413460-kbnb2jsa9kme29g8sv3iiu06juh3b4v6.apps.googleusercontent.com';
const GO_CLIENT_SECRETE   = 'Og6l4eIPfFIj5eQBNtuKjHqB';
const GO_URI_REDIRECT     = 'http://thermomusic.com/profile/index';

// API FACEBOOK
const FB_ID_API        = '347475152311937';
const FB_SECRET_KEY    = 'vlvFHTl0ywBZDCMpMuIq0zzX';
const FB_GRAPH_VERSION = 'v2.8';

    // array con el nombre de los meses
const MONTHS = [
    'Enero', 
    'Febrero',
    'Marzo', 
    'Abril',
    'Mayo', 
    'Junio',
    'Julio', 
    'Agosto',
    'Septiembre', 
    'Octubre',
    'Noviembre', 
    'Diciembre'
];
