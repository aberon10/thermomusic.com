'use strict';

import React from 'react';
import ReactDOM from 'react-dom';

import Ajax from '../../Libs/Ajax';

import AppPlaylist from '../../app/Music/Playlist';
import MenuPopUp from '../MenuPopUp/index';
import { displayNotification, checkXMLHTTPResponse } from '../../app/utils/Utils';

function addTrackToFavorites(e) {
	let target = e.target;

	if (target.tagName === 'SPAN')
		target = target.parentNode;

	Ajax.post({
		url: '/music/add_remove_track_to_favorites',
		responseType: 'json',
		data: { id: e.target.dataset.id }
	}).then((response) => {
		checkXMLHTTPResponse(response);
		if (response.success) {
			if (target.classList.contains('color-red')) {
				target.classList.remove('color-red');
			} else {
				target.classList.add('color-red');
			}

			if (target.dataset.favorite == 'true') {
				let row = target.parentNode;
				let container = row.parentNode;
				container.removeChild(row);
				if (container.children.length === 0)
					document.querySelector('#nav-bar-container a[href="/music"]').click();
			}

		}
		MenuPopUp.resetStates();
		displayNotification(response.message);
	}).catch((error) => { });
}

function createDialogDelete() {
	ReactDOM.render(
		<div className="content-spacing">
			<div className="content-spacing__header">
				<h1 className="content-spacing-title">
					¿Estás seguro que deseas eliminar esta playlist?
				</h1>
			</div>
			<div className="content-spacing__body">
				<div className="buttons-group">
					<a href="#" className="button  button-red" onClick={deletePlaylist}>Eliminar</a>
					<a href="#" className="button  button-gray"
						onClick={removeClassModal}
						data-id-modal="modal-dialog"
					>Cancelar</a>
				</div>
			</div>
		</div>,
		document.querySelector('#modal-dialog .content-spacing')
	);
}

function openDialogDelete(e) {
	sessionStorage.setItem('idPlaylist', e.target.dataset.idplaylist);

	let container = document.getElementById('modal-dialog');
	let closeButton = container.querySelector('#close-modal-dialog');
	container.querySelector('.content-spacing').innerHTML = '';

	closeButton.removeEventListener('click', removeClassModal);
	closeButton.addEventListener('click', removeClassModal);

	createDialogDelete();
	container.classList.add('modal-active');
}

function deletePlaylist() {
	AppPlaylist.delete({
		id: sessionStorage.getItem('idPlaylist')
	});
	sessionStorage.removeItem('idPlaylist');
}

function _resetMessageError() {
	Array.from(document.querySelectorAll('.error-message')).forEach((el) => el.innerHTML = '');
}

function _resetForm() {
	Array.from(document.querySelectorAll('.modal-dialog form')).forEach((el) => el.reset());
}

function _validatePlaylistName(playlistname) {
	_resetMessageError();
	let errorMessage = playlistname.nextElementSibling;

	if (playlistname.value === '') {
		errorMessage.innerHTML = 'Por favor, ingresa un nombre';
		return false;
	} else if (playlistname.value.length > 100) {
		errorMessage.innerHTML = 'Utiliza como máximo 100 caracteres';
		return false;
	}
	return true;
}

function onBlurPlaylistname(e) {
	e.target.value = e.target.dataset.oldname;
}
function onFocusPlaylistname(e) {
	e.target.value = e.target.dataset.name;
}

function updatePlaylistname(e) {
	e.preventDefault();
	let playlistname = e.target.children[0];

	if (_validatePlaylistName(playlistname)) {
		playlistname.dataset.oldname = playlistname.value;
		playlistname.dataset.name = playlistname.value;
		AppPlaylist.create({
			playlistname: playlistname.value,
			idPlaylist: e.target.children[1].value
		});
	}
}

function onSubmit(e) {
	e.preventDefault();
	let playlistname = document.getElementById('playlistname');
	if (_validatePlaylistName(playlistname)) {
		AppPlaylist.errorElement = playlistname.nextElementSibling;
		AppPlaylist.create({
			playlistname: playlistname.value,
			idPlaylist: -1,
			idTrack: sessionStorage.getItem('id_track')
		});
	}
}

function closeAllModals() {
	const modals = Array.from(document.querySelectorAll('.modal-dialog'));
	modals.forEach((modal) => removeClassModal(modal));
}

function removeClassModal(el) {
	if (el.type === 'click') {
		el.preventDefault();
		el = document.getElementById(el.target.dataset.idModal);
		sessionStorage.clear();
	}

	if (el.classList.contains('modal-active')) {
		el.classList.remove('modal-active');
	}

}

function addClassModal(el) {
	_resetForm();
	_resetMessageError();
	closeAllModals();

	if (el.type === 'click') {
		el = document.getElementById(el.target.dataset.idModal);
	}

	if (!el.classList.contains('modal-active')) {
		el.classList.add('modal-active');
	}
}

export {
	removeClassModal,
	closeAllModals,
	addClassModal,
	onSubmit,
	updatePlaylistname,
	onBlurPlaylistname,
	onFocusPlaylistname,
	openDialogDelete,
	addTrackToFavorites
};
