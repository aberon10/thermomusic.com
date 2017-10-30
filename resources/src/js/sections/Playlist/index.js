'use strict';

// Dependencies
import React from 'react';
import { Link } from 'react-router-dom';

import Ajax from '../../Libs/Ajax';

// Components
import MainContent from '../../components/Main';
import TrackList from '../../sections/components/TrackList';
import Notification from '../../components/Notification/index';
import {
	updatePlaylistname,
	onFocusPlaylistname,
	onBlurPlaylistname,
	openDialogDelete
} from '../../components/ModalForm/utils';
import { stringFromCharCode } from '../../app/utils/Utils';

import inFavorites from '../Explorer/components/util';

export default class Playlist extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			element: null
		};

		Playlist._loadData = Playlist._loadData.bind(this);
		Playlist.updateState = Playlist.updateState.bind(this);
	}

	componentDidMount() {
		let idPlaylist = this.props.match.params.id;
		Ajax.post({
			url: '/playlist/get_content_playlist',
			responseType: 'json',
			data: { id: idPlaylist }
		}).then((response) => {
			this.setState({
				element: Playlist._loadData(response)
			});
		}).catch((error) => {});
	}

	static updateState() {
		document.querySelector('#nav-bar-container a[href="/music"]').click();
	}

	static _loadData(response) {
		let element = <Notification message={response.message} classes='blue' />;
		let playlistYear = null;
		let playlist = null;

		if (response.playlist) {
			let countTracks = `${response.data.length} Canciones`;
			let playlistname = stringFromCharCode(response.playlist.nombre_lista);
			playlistYear = response.playlist.created_at.split(' ')[0].split('-')[0];
			playlistname = playlistname.length > 10 ? playlistname.substr(0, 10) + '...' : playlistname;

			playlist = (
				<div className="album-container__image">
					<div className="cover-artist-container">
						<div className="cover-artist">
							<div className="cover-artist__header">
								<div className="cover-artist-image__improved  bg-alice-dark" data-idplaylist={response.playlist.id_lista} onClick={null}>
									<i className='cover-artist-icon  icon-note' data-idplaylist={response.playlist.id_lista}></i>
								</div>
								<i className="icon-ellipsis-h  button"
									style={{
										position: 'absolute',
										right: '8px',
										top: '8px',
										cursor: 'pointer'
									}}
									onClick={openDialogDelete}
									data-idplaylist={response.playlist.id_lista}>
								</i>
							</div>
							<div className="cover-artist__footer">
								<div className="album-info">
									<h3 className="album-info__name">
										<form onSubmit={updatePlaylistname} id="form-update-playlistname">
											<input
												type="text"
												onBlur={onBlurPlaylistname}
												onFocus={onFocusPlaylistname}
												defaultValue={playlistname}
												data-name={stringFromCharCode(response.playlist.nombre_lista)}
												data-oldname={playlistname}
												className="form-control"
												style={{
													color: '#FFF',
													backgroundColor: 'transparent',
													border: 'none',
													fontSize: 2 + 'rem',
													textAlign: 'center'
												}} />
											<input type="hidden" defaultValue={response.playlist.id_lista} />
										</form>
									</h3>
									<p className="album-info__artist">{`Por ${response.playlist.user}`}</p>
									<p className="album-info__year">{`Año ${playlistYear} - ${countTracks}`}</p>
								</div>
							</div>
						</div>
					</div>
				</div>
			);

			element = (
				<MainContent>
					<div className="album-container">
						{playlist}
						<div className="album-container__content">
							<h1 style={{color: '#fff'}}>Oops! Al parecer esta playlist esta vacía.</h1>
							<h2>
								<Link to='/user'>
									Vamos, anímate! y agrega alguna canción que te guste.
								</Link>
							</h2>
						</div>
					</div>
				</MainContent>
			);
		}

		if (response.data && response.data.length > 0) {
			let tracks = [];
			response.data.forEach((item) => {
				tracks.push({
					id: item.id_cancion,
					src: item.src_audio,
					trackName: item.nombre_cancion,
					duration: item.duracion,
					counter: item.contador,
					srcAlbum: encodeURI(item.src_img),
					artist: `por ${item.nombre_artista}`,
					playlist: true,
					idPlaylist: response.playlist.id_lista,
					favorite: inFavorites(response.favorites, item.id_cancion),
					inFavoritePage: false
				});
			});

			element = (
				<MainContent>
					<div className="album-container">
						{playlist}
						<div className="album-container__content">
							<TrackList data={tracks} />
						</div>
					</div>
				</MainContent>
			);
		}

		return element;
	}

	render() {
		return (
			<div>{this.state.element}</div>
		);
	}
}
