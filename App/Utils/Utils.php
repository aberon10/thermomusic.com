<?php

namespace App\Utils;

/**
 * days_in_month($month, $year)
 * Returns the number of days in a given month and year, taking into account leap years.
 *
 * @param int $month: numeric month (integers 1-12)
 * @param int $year: numeric year (any integer)
 * @return int
 */
function days_in_month($month, $year) {
	// calculate number of days in a month
	return $month == 2 ? ($year % 4 ? 28 : ($year % 100 ? 29 : ($year % 400 ? 28 : 29))) : (($month - 1) % 7 % 2 ? 30 : 31);
}

/**
 * compare_dates
 * Compara dos fechas y devuelve la diferencia en dias.
 * Recibie dos fechas con formato DD-MM-AAAA.
 * Retorna `false` en caso de que alguna de las fechas no sea valida. De lo contrario retorna un `int`.
 * @param  string $fd first date
 * @param  string $sd second date
 * @return false|int
 */
function compare_dates($fd, $sd) {
    list($first_date_day, $first_date_month, $first_date_year) = explode('-', $fd);
    list($second_date_day, $second_date_month, $second_date_year) = explode('-', $sd);
    $first_date_julian  = gregoriantojd($first_date_month, $first_date_day, $first_date_year);
    $second_date_julian = gregoriantojd($second_date_month, $second_date_day, $second_date_year);

	if (!checkdate($first_date_month, $first_date_day, $first_date_year) ||
		!checkdate($second_date_month, $second_date_day, $second_date_year)) {
        return false;
	}
	return $first_date_julian - $second_date_julian;
}
