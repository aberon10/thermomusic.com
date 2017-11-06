'use strict';

// Dependencies
import React from 'react';
import { Link } from 'react-router-dom';

// utils
import {substr} from '../../utils';

// Components
import Finder from '../index';
import ResultBox from '../ResultBox';

// app
import PlaybackQueue from '../../../app/PlaybackQueue/PlaybackQueue';
import TMPlayer from '../../../app/TMPlayer/TMPlayer';
import prepareSong from '../../../app/TMPlayer/';

function initSong(e) {
	let cardItem = e.target.parentNode.parentNode;
	let containerSongs = cardItem.parentNode.parentNode;
	let cardItemOld = containerSongs.querySelector('.card-item.active');

	if (cardItemOld && cardItemOld !== cardItem) {
		let button = cardItemOld.querySelector('.card-picture__button');
		cardItemOld.classList.remove('active');
		button.classList.remove('icon-pause');
		button.classList.add('icon-play-2');
	}

	cardItem.classList.add('active');

	if (e.target.classList.contains('icon-play-2')) {
		e.target.classList.remove('icon-play-2');
		e.target.classList.add('icon-pause');
	} else {
		e.target.classList.remove('icon-pause');
		e.target.classList.add('icon-play-2');
	}

	prepareSong(e);
	sessionStorage.setItem('seeAll', true);
	Song.updateState(JSON.parse(sessionStorage.getItem('songs')));
}

export default class Song extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			element: null
		};

		Song.updateState = Song.updateState.bind(this);
		Song.resetState = Song.resetState.bind(this);
		Song.createContent = Song.createContent.bind(this);
	}

	static resetState() {
		this.setState({ element: null });
		sessionStorage.removeItem('songs');
	}

	static updateState(songs) {
		this.setState({ element: Song.createContent(songs) });
	}

	static createContent(songs) {
		sessionStorage.setItem('songs', JSON.stringify(songs));
		let songsElements = [];
		let element = null;
		let LinkSeeAll = null;
		let onClickEventHandler = this.state.element ? ResultBox.resetState : Finder.resetState;

		if (songs && songs.length) {
			songs.forEach((song) => {
				let data = JSON.stringify({
					id: song.id_cancion,
					src: song.src_audio,
					duration: song.duracion,
					trackName: song.nombre_cancion,
					srcAlbum: song.src_img,
					artist: song.nombre_artista,
					playlist: false,
					idPlaylist: null
				});
				let classNameCardtem = 'card-item';
				let classNameButtonPlay = 'icon-play-2';

				if (PlaybackQueue.tracks && PlaybackQueue.tracks.length) {
					if (PlaybackQueue.tracks[PlaybackQueue.indexTrack].id === song.id_cancion) {
						classNameCardtem += '  active';
						classNameButtonPlay = TMPlayer.isPaused() ? 'icon-play-2' : 'icon-pause';
					}
				}

				songsElements.push(
					<div className="card-list" key={song.id_cancion}>
						<div className={classNameCardtem} data-track={data}>
							<div className="card-picture">
								<figure className="thumbnail">
									<img src={'http://thermobackend.com/storage/' + song.src_img}
										alt={song.nombre_cancion} />
								</figure>
								<span className={`card-picture__button  ${classNameButtonPlay}`} onClick={initSong}></span>
							</div>
							<div className="card-info">
								<Link to={'/album/index/' + song.id_album} onClick={onClickEventHandler}>
									<h2 className="card-info__heading-2">{substr(song.nombre_cancion)}</h2>
								</Link>
								<Link to={'/album/index/' + song.id_album} onClick={onClickEventHandler}>
									<h3 className="card-info__heading-3">{substr(song.nombre)}</h3>
								</Link>
							</div>
						</div>
					</div>
				);
			});
		}

		if (sessionStorage.getItem('seeAll')) {
			LinkSeeAll = <span to='#'
				className="see-all"
				onClick={ResultBox.findContent}
				style={{ cursor: 'pointer' }}
				data-entitie='song'
				data-search={document.getElementById('search').value}
			>ver todos</span>;
		}

		if (songsElements.length) {
			element = <div className="card-group">
				<h3 className="card-group-title">Canciones</h3>
				<div>
					{songsElements}
				</div>
				{LinkSeeAll}
			</div>;
		}

		return element;
	}

	render() {
		let element = this.props.songs ? Song.createContent(this.props.songs) : this.state.element;
		return (
			<div>
				{element}
			</div>
		);
	}
}

Song.defaultProps = {
	songs: null
};
