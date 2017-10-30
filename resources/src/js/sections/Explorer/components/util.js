'use strict';

export default function inFavorites(fav, track) {
	if (fav && (fav.constructor === Object || fav.constructor === Array)) {
		let favorites = fav;

		if (fav.constructor === Object)
			favorites = Object.keys(fav).map(key => [fav[key]]);

		const count = favorites.length;
		let i = 0;
		while (i < count) {
			if (fav[i].id_cancion === track)
				return true;
			i++;
		}
	}
	return false;
}
