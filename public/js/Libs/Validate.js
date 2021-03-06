'use strict';

var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

var METHOD_PREFIX = '_validate';
var REGX_NAME = /^[A-Za-z-ÁÉÍÓÚÑáéíóúñ\s]+$/;
var REGX_USERNAME = /^[\w_\.\-]{4,30}$/;
var REGX_EMAIL = /^[(\w)+(\w_\.)]{4,60}@\w{2,25}\.\w{2,20}$/;
var REGX_FORMATS_OF_DATES = /^(0?[1-9]|[12][0-9]|3[01])[\/|-](0?[1-9]|[1][012])[\/|-]((19|20)?[0-9]{2})$/;

/**
 * Clase utilizada para realizar distintas validaciones.
 * @author [abzerox]
 * @license <https://opensource.org/licenses/GPL-3.0> GNU GPL version 3
 * @version 1.0
 */

var Validate = function () {
	function Validate() {
		_classCallCheck(this, Validate);
	}

	_createClass(Validate, null, [{
		key: 'resolver',


		/**
      * resolver
      * Realiza las validaciones correspondientes sobre un valor dado.
      * 
      * @param  {String} |int|float|array|file  $input   
      * @param  {Object}  $filters {'filter': 'message'} | {'filter': ['value', 'message']}
      * @return {Boolean}          
      */
		value: function resolver(input, filters) {
			var result = null;
			var method = null;
			for (var filter in filters) {
				if (filters.hasOwnProperty(filter)) {
					result = null;
					if (filter === 'min_length' || filter === 'max_length') {
						var letters = filter.split('_');
						method = METHOD_PREFIX + capitalizeFirstLetter(letters[0]) + capitalizeFirstLetter(letters[1]);
					} else {
						method = METHOD_PREFIX + capitalizeFirstLetter(filter);
					}
					if (method && method in Validate) {
						if (['regex', 'min_length', 'max_length'].indexOf(filter) !== -1) {
							if (filters[filter].constructor !== Array || filters[filter].length !== 2) {
								throw new Error('El filtro ' + filter + ' debe tener como valor un array con la forma [valor, mensaje]');
							} else {
								result = Validate[method](filters[filter][0], input);
							}
						} else {
							result = Validate[method](input);
						}

						if (!result) {
							return filters[filter].constructor === Array ? filters[filter][1] : filters[filter];
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

	}, {
		key: '_validateRequire',
		value: function _validateRequire(input) {
			return input.length === 0 ? false : true;
		}

		/**
   * _validateRegex
   * @param  {RegExp} input
   * @return {Boolean}
   */

	}, {
		key: '_validateRegex',
		value: function _validateRegex(regex, input) {
			return regex.test(input);
		}

		/**
   * _validateUsername
   * @param  {String} input
   * @return {Boolean}
   */

	}, {
		key: '_validateUsername',
		value: function _validateUsername(input) {
			return REGX_USERNAME.test(input);
		}

		/**
   * _validateName
   * @param  {String} input
   * @return {Boolean}
   */

	}, {
		key: '_validateName',
		value: function _validateName(input) {
			return REGX_NAME.test(input);
		}

		/**
   * _validateEmail
   * @param  {String} input
   * @return {Boolean}
   */

	}, {
		key: '_validateEmail',
		value: function _validateEmail(input) {
			return REGX_EMAIL.test(input);
		}

		/**
   * _validateDate
   * @param  {String} input
   * @param  {String} sep
   * @return {Boolean}
   */

	}, {
		key: '_validateDate',
		value: function _validateDate(input) {
			var sep = arguments.length > 1 && arguments[1] !== undefined ? arguments[1] : '-';

			if (REGX_FORMATS_OF_DATES.test(input)) {
				var values = input.split(sep);
				if (values.length === 3) {
					var date = new Date(values[2], Number(values[1]) - 1, values[0]);
					return date.getFullYear() === Number(values[2]) && date.getMonth() === Number(values[1]) - 1 && date.getDate() === Number(values[0]);
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

	}, {
		key: '_numberOfDays',
		value: function _numberOfDays(month, year) {
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

	}, {
		key: '_validateMaxLength',
		value: function _validateMaxLength(maxValue, input) {
			if (input.constructor === String || typeof input === 'string') {
				return input.length > maxValue ? false : true;
			}
			return false;
		}

		/**
   * _validateMinLength
   * @param  {Number} minValue
   * @param  {String} input
   * @return {Boolean}
   */

	}, {
		key: '_validateMinLength',
		value: function _validateMinLength(minValue, input) {
			if (input.constructor === String || typeof input === 'string') {
				return input.length < minValue ? false : true;
			}
			return false;
		}
	}]);

	return Validate;
}();