import Ajax from '../Libs/Ajax';
'use strict';

class Advertising {
	static get() {
		Ajax.post({
			url: '/advertising/index/',
			responseType: 'json',
			data: null
		}).then((response) => {
			if (response && Object.keys(response).length > 0) {
				Advertising.audios = Object.keys(response).map(key => response[key]);
			}
		}).catch((error) => {});
	}
}

Advertising.audios = [];
Advertising.index = 0;
export default Advertising;
