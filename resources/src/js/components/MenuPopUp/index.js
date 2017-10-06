'use strict';

// Dependencies
import React from 'react';

// Components
import Modal from '../Modal/index';

// app
import PlaybackQueue from '../../app/PlaybackQueue/PlaybackQueue';

// Config
import Config from '../../config';

export default class MenuPopUp extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			data: null,
			visible: false
		};

		MenuPopUp.resetStates = MenuPopUp.resetStates.bind(this);
		MenuPopUp.updateState = MenuPopUp.updateState.bind(this);
		MenuPopUp.create = MenuPopUp.create.bind(this);
	}
	static resetStates() {
		this.setState({ data: null, visible: false });
	}

	static hide(e) {
		if (e.target.id === 'modal') {
			MenuPopUp.resetStates();
		}
	}

	static updateState(jsonTrack) {
		this.setState({
			data: jsonTrack,
			visible: true
		});
	}

	static create() {
		let element = null;

		if (this.state.data && typeof this.state.data === 'string') {
			let data = JSON.parse(this.state.data);

			// Button Add/Remove Waiting List
			let existTrackInList = PlaybackQueue.inQueue(data.id) !== false;
			let textButtonPlaylist = existTrackInList ? 'Eliminar de la lista de espera' : 'Añadir a la lista de espera';
			let classIcon = existTrackInList ? 'icon-close' : 'icon-list-add';
			let iconWaitingList = <span className={`nav-list__link ${classIcon}`} onClick={PlaybackQueue.updateQueue}>{textButtonPlaylist}</span>;

			if (existTrackInList && PlaybackQueue.tracks.length === 1) {
				iconWaitingList = null;
			}

			element = (
				<Modal classes={this.state.visible === true ? 'modal-popup' : ''} clickEventHandler={MenuPopUp.hide}>
					<div className="menu-popup  zoomIn">
						<div className="menu-popup__header">
							<div className="menu-popup__header-thumbnails">
								<img src={`${Config.urlResource}/${data.srcAlbum}`} alt={data.artist} />
							</div>
							<div className="menu-popup__header-info">
								<h2>{data.trackName}</h2>
								<h3>{data.artist}</h3>
							</div>
						</div>
						<div className="menu-popup__content">
							<ul className="nav-list  group" data-track={this.state.data}>
								{PlaybackQueue.existQueue() && (
									<li className="nav-list__item">
										{iconWaitingList}
									</li>
								)}
								<li className="nav-list__item">
									<span className="nav-list__link  icon-list-add"> Añadir a una playlist... </span>
								</li>
								<li className="nav-list__item">
									<span className="nav-list__link  icon-heart">  Añadir a mi música...</span>
								</li>
								<li className="nav-list__item">
									<span className="nav-list__link  icon-cd"> Ir al artista</span>
								</li>
								<li className="nav-list__item">
									<span className="nav-list__link  icon-note"> Ir al album</span>
								</li>
							</ul>
						</div>
					</div>
				</Modal>
			);
		}

		return element;
	}

	render() {
		let element = MenuPopUp.create();

		return (
			<div>
				{element}
			</div>
		);
	}
}
