'use strict';

function substr(str, len=18) {
	return String(str).length > len ? str.substr(0, len)+'...' : str;
}

export {substr};
