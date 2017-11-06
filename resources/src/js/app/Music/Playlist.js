'use strict';

import React from 'react';
import ReactDOM from 'react-dom';

import Ajax from '../../Libs/Ajax.js';

import {
	closeAllModals,
	removeClassModal,
	addClassModal
} from '../../components/ModalForm/utils';
import { displayNotification, stringFromCharCode } from '../utils/Utils';

// components
import Playlist from '../../sections/Playlist/index';
import MenuPopUp from '../../components/MenuPopUp/index';

export default class AppPlaylist {
	static create(data) {
		Ajax.post({
			url: '/playlist/create',
			responseType: 'json',
			data: data,
		}).then((response) => {
			if (response.success) {
				if (location.pathname === '/music') {
					Playlist.updateState();
				}

				if (response.idPlaylist && data.idTrack) {
					AppPlaylist.addTrack({idPlaylist: response.idPlaylist, idTrack: data.idTrack});
				} else {
					displayNotification(response.message);
				}

				sessionStorage.removeItem('id_track');
				removeClassModal(document.getElementById('modal-form-playlist'));
				removeClassModal(document.getElementById('modal-popup'));
				closeAllModals();
			} else {
				if (AppPlaylist.errorElement && AppPlaylist.errorElement.nodeType === 1) {
					AppPlaylist.errorElement.innerHTML = response.message;
				}
			}
		}).catch((error) => {});
	}

	static addTrack(entrie) {
		let idPlaylist = null;
		let idTrack = null;
		let modal = document.getElementById('modal-dialog');
		let error = modal.querySelector('.error-message');
		error.innerHTML = '';

		if (entrie.type === 'click') {
			entrie.preventDefault();
			idPlaylist = entrie.target.dataset.id;
			idTrack = sessionStorage.getItem('id_track');
		} else {
			({idPlaylist, idTrack} = entrie);
		}

		Ajax.post({
			url: '/playlist/add_track_to_playlist',
			responseType: 'json',
			data: {idPlaylist: idPlaylist, idTrack: idTrack}
		}).then((response) => {
			if (response.success) {
				if (/^(\/playlist\/index)\/[0-9]+$/.test(location.pathname))
					Playlist.updateState();

				MenuPopUp.resetStates();
				removeClassModal(modal);
				displayNotification(response.message);
				sessionStorage.removeItem('id_track');
			} else {
				error.innerHTML = response.message;
			}
		}).catch((error) => {});
	}

	static getByUser() {
		Ajax.post({
			url: '/playlist/get_user_playlists',
			responseType: 'json',
			data: '',
		}).then((response) => {
			AppPlaylist.list(response);
		}).catch((error) => {});
	}

	static createElementPlaylist(data) {
		return (
			<div key={data.id} className="cover-artist  brightness-image">
				<div className="cover-artist__header">
					<a href="#" data-id={data.id}>
						<div className="cover-artist-image__improved" data-id={data.id} onClick={AppPlaylist.addTrack}>
							<i className="icon-note cover-artist-icon" data-id={data.id}></i>
						</div>
					</a>
				</div>
				<div className="cover-artist__footer">
					<span className="cover-artist-name">{stringFromCharCode(data.name)}</span>
				</div>
			</div>
		);
	}

	static list(response) {
		let container = document.querySelector('#modal-dialog .content-spacing');
		let containerChilds = [];
		container.innerHTML = '';

		for (let i = 0; i < response.data.length; i++) {
			containerChilds.push(
				AppPlaylist.createElementPlaylist({
					id: response.data[i].id_lista,
					name: response.data[i].nombre_lista
				})
			);
		}

		ReactDOM.render(
			<div>
				<div className="content-spacing__header">
					<h1 className="content-spacing-title">Agregar a playlist</h1>
					<a href="#" className="button  button-cyan  radius" data-id-modal="modal-form-playlist"
						onClick={addClassModal}>
						Nueva Playlist
					</a>
				</div>
				<div className="content-spacing__body">
					<p className="error-message block"></p>
					<div className="cover-artist-container">{containerChilds}</div>
				</div>
			</div>,
			container
		);

		MenuPopUp.resetStates();
		document.getElementById('close-modal-dialog').removeEventListener('click', removeClassModal);
		document.getElementById('close-modal-dialog').addEventListener('click', removeClassModal);
		document.getElementById('modal-dialog').classList.add('modal-active');
	}

	static delete(data) {
		Ajax.post({
			url: '/playlist/delete',
			responseType: 'json',
			data: {id: data.id}
		}).then((response) => {
			removeClassModal(document.getElementById('modal-dialog'));
			displayNotification(response.message);
			Playlist.updateState();
		}).catch((error) => {});
	}

	static removeSongToPlaylist(e) {
		let dataJSON = e.target.dataset.track;
		let data = JSON.parse(e.target.dataset.track);
		let idTrack = data.id;
		let idPlaylist = data.idPlaylist;
		Ajax.post({
			url: '/playlist/remove_song_to_playlist',
			responseType: 'json',
			data: { idTrack: idTrack, idPlaylist: idPlaylist }
		}).then((response) => {
			let element = document.querySelector(`.tracklist-item[data-track='${dataJSON}']`);
			let parent = element.parentNode;
			parent.removeChild(element);

			if (parent.children.length === 0) {
				history.back();
			}

			MenuPopUp.resetStates();

			if (!response.success)
				displayNotification(response.message);
		}).catch((error) => {});
	}
}

AppPlaylist.prototype.errorElement = null;
