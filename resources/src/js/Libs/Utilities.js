'use strict';

function capitalizeFirstLetter(string) {
	return string.charAt(0).toUpperCase() + string.slice(1);
}

function reportError(element, result, classError = 'has-error') {
	if (result !== true) {
		element.parentElement.classList.add(classError);
		element.nextElementSibling.innerHTML = result;
		return false;
	} else {
		element.parentElement.classList.remove(classError);
		element.nextElementSibling.innerHTML = '';
		return true;
	}
}
