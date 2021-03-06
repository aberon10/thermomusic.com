'use strict';

function stringFromCharCode(str) {
	return String(str).replace(/&#([0-9]+);/g, (match, $1) => {
		return String.fromCharCode($1);
	});
}

function timeFormat(time) {
	let minutes = parseInt(time / 60);
	let seconds = parseInt(time % 60);

	if (seconds < 10) {
		seconds = '0' + seconds;
	}

	if (minutes < 10) {
		minutes = '0' + minutes;
	}

	return minutes + ':' + seconds;
}

function getDurationOfTheAudio(tracks) {
	let times = [];
	tracks.forEach((track) => times.push(track.duration));
	return times;
}

function totalTimeInStringFormat(tracks) {
	let hours = 0;
	let seconds = 0;
	let minutes = 0;
	let times = getDurationOfTheAudio(tracks);

	times.forEach((time) => {
		let timeInSlice = time.split(':');

		if (timeInSlice.length === 2) { // MM:SS
			minutes += parseInt(timeInSlice[0]);
			seconds += parseInt(timeInSlice[1]);
		} else if (timeInSlice.length === 3) { // HH:MM:SS
			hours += parseInt(timeInSlice[0]);
			minutes += parseInt(timeInSlice[1]);
			seconds += parseInt(timeInSlice[2]);
		}
	});

	// Seconds To Minutes
	if (seconds >= 60) {
		minutes += parseInt(seconds / 60);
		seconds = parseInt(seconds % 60);
	}

	// Minutes To Hours
	if (minutes >= 60) {
		hours += parseInt(minutes / 60);
		minutes = parseInt(minutes % 60);
	}

	let minutesAndSeconds = timeFormat(parseInt(minutes * 60) + seconds);

	return `${hours < 10 ? '0' + hours : hours}:${minutesAndSeconds}`;
}

function displayNotification(message, time=3000) {
	let notification = document.getElementById('notification');
	notification.children[0].innerHTML = message ? message : '';
	notification.classList.add('visible');
	setTimeout(() => {
		notification.classList.remove('visible');
		notification.children[0].innerHTML = '';
	}, time);
}


function removeSessionItem(item) {
	if (item) {
		if (item.constructor === Array) {
			item.forEach((i) => sessionStorage.removeItem(i));
		} else if (typeof item === 'string') {
			sessionStorage.removeItem(item);
		}
	} else {
		sessionStorage.clear();
	}
}

function checkXMLHTTPResponse(response) {
	if (response.hasOwnProperty('status') && response.status === 401) {
		window.location.href = response.urlRedirect;
	}
}

export {
	timeFormat,
	totalTimeInStringFormat,
	displayNotification,
	removeSessionItem,
	stringFromCharCode,
	checkXMLHTTPResponse
};
