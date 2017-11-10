'use strict';

function changeThePositionOfElementsInArray(d) {
	for (let i = 0; i < d.length; i++) {
		for (let x = 0; x < d.length; x++) {
			if (Number.parseInt(d[i].date) > Number.parseInt(d[x].date)) {
				let z = d[i];
				d[i] = d[x];
				d[x] = z;
			}
		}
	}

	return d;
}

export default changeThePositionOfElementsInArray;
