<?php

namespace Config;

/**
 * Configuraciones, rutas de ficheros y restricciones propias de la aplicación.
 *
 * @author Alejandro Berón <alejandroberon10@gmail.com>
 * @license <https://opensource.org/licenses/GPL-3.0> GNU GPL versión 3
 * @version 1.0
 */

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

// Planes de pago
const PAYMENT_PLANS = array('5.99');
