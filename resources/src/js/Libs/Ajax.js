'use strict';

/**
 * Ajax
 * Esta clase permite realizar peticiones via ajax de forma sencilla,
 * utilizando los metodos GET y POST. 
 * La sencilles de la clase se ve beneficiada por el uso del objeto Promise 
 * implementado en el ultimo estandar de ECMASCRIPT 6 - ES2015.
 * 
 * Ejemplo - Request POST:
 * 
 * let data = {
 *   name: "Juan",
 *   lastname: "Perez"
 * };
 * 
 * Ajax
 *  .post({
 *     url: 'http://localhost/test.php',
 *          responseType: 'json',
 *          data: data
 *      })
 *      .then((response) => {
 *          console.log(response);
 *      })
 *      .catch((error) => {
 *          console.log(error);
 *      });
 * 
 * Tanto el método .post como .get reciben como parámetro un objeto. 
 * Dicho objeto,cuenta con 3 propiedades:
 * url: String, de la dirección url (relativa o absoluta). 
 * [ responseType ]: String, Debe ser uno de los siguientes valores:                                              
 *                - text (default)
 *                - arraybuffer
 *                - blob
 *                - json
 *                - document
 * [ data ]: String|FormData|Object.  
 * @author  Alejandro Berón <alejandroberon10@gmail.com>
 * @license <https://opensource.org/licenses/GPL-3.0> GNU GPL version 3
 * @version 1.0.0
 */
class Ajax {

    /**
     * _validateData
     * @param {String|Object} data 
     * @return {Boolean}     
     */
    static _validateData(data) {
        if (/^(([a-z0-9]+)=.)+(.)*$/.test(data)) {
            return true;
        } else if (typeof data === 'object') {
            if (data.constructor === Object || data.constructor === FormData) {
                return true;
            }
        }
        return false;
    }

    /**
     * _validateParams
     * @param {String} url 
     * @param {String} responseType 
     * @param {String|Object} data 
     * @return {Boolean}
     */
    static _validateParams(url, responseType, data) {
        const RESPONSE_TYPE = new Set();
        RESPONSE_TYPE.add('');
        RESPONSE_TYPE.add('arraybuffer');
        RESPONSE_TYPE.add('blob');
        RESPONSE_TYPE.add('json');
        RESPONSE_TYPE.add('document');
        RESPONSE_TYPE.add('text');

        if (!url) {
            throw new Error(`[ ERROR ] the url parameter is required.`);
        }

        if (!RESPONSE_TYPE.has(responseType)) {
            throw new Error(`[ ERROR ] ${responseType} not valid.`);
        }

        if (data) {
            if (!this._validateData(data)) {
                throw new Error(`[ ERROR ] ${data} Is not a valid type.`);
            }
        }
    }

    /**
     * _getJSON
     * @param {Object} data 
     * @return {String}
     */
    static _getJSON(data) {
        return JSON.stringify(data);
    }

    /**
     * init
     * Create new object XMLHttpRequest.
     * @return {Object}
     */
    static _init() {
        if (window.XMLHttpRequest) {
            return new XMLHttpRequest();
        }
    }

    /**
     * _request
     * @param {Object} request 
     */
    static _request(request, resolve, reject) {
        let http = Ajax._init();
        http.responseType = request.responseType;

        // open request
        http.open(request.method, request.url, true);

        if (request.data) {
            if (request.method === 'POST') {
                if (request.data.constructor === Object) {
                    request.data = Ajax._getJSON(request.data);
                    http.setRequestHeader('Content-Type', 'application/json; charset=UTF-8');
                } else if (request.data.constructor === String || typeof request.data === 'string') {
                    http.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                }
            }
        }

        http.onload = () => {
            if (http.status === 200) {
                resolve(http.response);
            } else {
                reject(new Error(`[ ERROR ] ${http.statusText}: ${http.statusText}`));
            }
        };

        http.onerror = () => {
            reject(new Error('Network Error'));
        };

        http.send(request.data);
    }

    /**
     * get
     * @param {Object} 
     *        url          {String}
     *        responseType {String}
     *        data         {String|Object}
     * @return {Object} - Promise
     */
    static get({ url, responseType = '', data = '' }) {
        return new Promise((resolve, reject) => {
            Ajax._validateParams(url, responseType, data);

            if (typeof data === 'string' || data.constructor === String) {
                url += `?${data}`;
            }

            Ajax._request({
                url: url,
                responseType: responseType,
                data: null,
                method: 'GET'
            }, resolve, reject);
        });
    }

    /**
     * post
     * @param {Object} 
     *         url          {String}
     *         responseType {String}
     *         data         {String|Object}
     * @return {Object} - Promise
     */
    static post({ url, responseType = '', data = '' }) {
        return new Promise((resolve, reject) => {
            Ajax._validateParams(url, responseType, data);
            Ajax._request({
                url: url,
                responseType: responseType,
                data: data,
                method: 'POST'
            }, resolve, reject);
        });
    }
}