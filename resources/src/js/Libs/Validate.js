'use strict';

const METHOD_PREFIX = '_validate';
const REGX_NAME = /^[A-Za-z-ÁÉÍÓÚÑáéíóúñ\s]+$/;
const REGX_USERNAME = /^[\w_\.\-]{4,30}$/;
const REGX_EMAIL = /^[(\w)+(\w_\.)]{4,60}@\w{2,25}\.\w{2,20}$/;
const REGX_FORMATS_OF_DATES = /^(0?[1-9]|[12][0-9]|3[01])[\/|-](0?[1-9]|[1][012])[\/|-]((19|20)?[0-9]{2})$/;

/**
 * Clase utilizada para realizar distintas validaciones.
 * @author [abzerox]
 * @license <https://opensource.org/licenses/GPL-3.0> GNU GPL version 3
 * @version 1.0
 */
class Validate {

	/**
     * resolver
     * Realiza las validaciones correspondientes sobre un valor dado.
     * 
     * @param  {String} |int|float|array|file  $input   
     * @param  {Object}  $filters {'filter': 'message'} | {'filter': ['value', 'message']}
     * @return {Boolean}          
     */
	static resolver(input, filters) {
		let result = null;
		let method = null;
		for (let filter in filters) {
			if (filters.hasOwnProperty(filter)) {
				result = null;
				if (filter === 'min_length' || filter === 'max_length') {
					let letters = filter.split('_');
					method = METHOD_PREFIX + capitalizeFirstLetter(letters[0]) + capitalizeFirstLetter(letters[1]);
				} else {
					method = METHOD_PREFIX + capitalizeFirstLetter(filter);
				}
				if (method && method in Validate) {
					if (['regex', 'min_length', 'max_length'].indexOf(filter) !== -1) {
						if (filters[filter].constructor !== Array || filters[filter].length !== 2) {
							throw new Error('El filtro '+filter+' debe tener como valor un array con la forma [valor, mensaje]');
						} else {
							result = Validate[method](filters[filter][0], input);
						}
					} else {
						result = Validate[method](input);
					}

					if (!result) {
						return (filters[filter].constructor === Array) ? filters[filter][1] : filters[filter];
					}
				} else {
					throw new Error('La propiedad ' + filter + ' no existe.');
				}
			}
		}
		return true;
	}

	/**
	 * _validateRequire
	 * @param  {Number | String} input
	 * @return {Boolean}
	 */
	static _validateRequire(input) {
		return input.length === 0 ? false : true;
	}

	/**
	 * _validateRegex
	 * @param  {RegExp} input
	 * @return {Boolean}
	 */
	static _validateRegex(regex, input) {
		return regex.test(input);
	}

	/**
	 * _validateUsername
	 * @param  {String} input
	 * @return {Boolean}
	 */
	static _validateUsername(input) {
		return REGX_USERNAME.test(input);
	}

	/**
	 * _validateName
	 * @param  {String} input
	 * @return {Boolean}
	 */
	static _validateName(input) {
		return REGX_NAME.test(input);
	}	

	/**
	 * _validateEmail
	 * @param  {String} input
	 * @return {Boolean}
	 */
	static _validateEmail(input) {
		return REGX_EMAIL.test(input);
	}

	/**
	 * _validateDate
	 * @param  {String} input
	 * @param  {String} sep
	 * @return {Boolean}
	 */
	static _validateDate(input, sep = '-') {
		if (REGX_FORMATS_OF_DATES.test(input)) {
			let values = input.split(sep);
			if (values.length === 3) {
				let date = new Date(values[2], Number(values[1]) - 1, values[0]);
				return ((date.getFullYear() === Number(values[2])) && 
				(date.getMonth() === Number(values[1]) - 1) && (date.getDate() === Number(values[0])));
			}
		}
		return false;
	}


	/**
	 * _numberOfDays 
	 * Esta función devuelve el número de días que tiene un determinado mes
	 * considerando también si el año es bisiesto.
	 * 
	 * @param  {Number} month
	 * @param  {Number} year
	 * @return {Number}
	 */
	static _numberOfDays(month, year) {
	    if (month === 1 && year % 4 === 0 && (year % 100 !== 0 || year % 400 === 0)) {
	        return 29;
	    } else {
	        return [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31][month];
	    }
	}

	/**
	 * _validateMaxLength
	 * @param  {Number} maxValue
	 * @param  {String} input
	 * @return {Boolean}
	 */
	static _validateMaxLength(maxValue, input) {
		if (input.constructor === String || typeof input === 'string') {
			return (input.length > maxValue) ? false : true;
		}
		return false;
	}

	/**
	 * _validateMinLength
	 * @param  {Number} minValue
	 * @param  {String} input
	 * @return {Boolean}
	 */
	static _validateMinLength(minValue, input) {
		if (input.constructor === String || typeof input === 'string') {
			return (input.length < minValue) ? false : true;
		}
		return false;
	}
}