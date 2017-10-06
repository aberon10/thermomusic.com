'use strict';

// Components
import MenuPopUp from '../../components/MenuPopUp/index';

function getDataTrack(e) {
	e.preventDefault();
	let jsonTrack = e.target.parentNode.parentNode.dataset.track;
	MenuPopUp.updateState(jsonTrack);
}

export {
	getDataTrack
};
