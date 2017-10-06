'use strict';

function isPathname(pathname) {
	return window.location.pathname === pathname;
}

export { isPathname };
