'use strict';

import Ajax from '../../Libs/Ajax';

class Song {
	static increaseCounter(id) {
		Ajax.post({
			url: '/song/increase_counter',
			responseType: 'json',
			data: {idTrack: id.toString().trim()}
		}).then((response) => {
			// console.log(response);
		}).catch((error) => {});
	}
}

export default Song;
