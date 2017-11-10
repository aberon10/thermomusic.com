'use strict';

// Dependencies
import React from 'react';

import Ajax from '../../Libs/Ajax';

import changeThePositionOfElementsInArray from './utils';

// Components
import Modal from '../Modal/index';
import Header from './components/Header';
import Artist from './components/Artist';
import Album from './components/Album';
import Song from './components/Song';
import ResultBox from './ResultBox';
import RecentSearches from './components/RecentSearches';
class Finder extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			visible: false
		};

		Finder.createContent = Finder.createContent.bind(this);
		Finder.resetState = Finder.resetState.bind(this);
		Finder.updateState = Finder.updateState.bind(this);
		Finder.findContent = Finder.findContent.bind(this);
		Finder.createContent = Finder.createContent.bind(this);
		Finder.hide = Finder.hide.bind(this);
	}

	static findContent(e) {
		const code = e.keyCode || e.which;
		const searchedWord = e.target.value.toString().trim();
		Artist.resetState();
		Album.resetState();
		Song.resetState();
		RecentSearches.resetState();

		// Busqueda Normal
		// Busqueda Avanzada
		if (searchedWord) {
			if (code === 13) {
				// Guardamos la búsqueda
				let searches = sessionStorage.getItem('searches');

				if (searches) {
					searches = JSON.parse(searches);
				} else {
					searches = [];
				}

				searches = changeThePositionOfElementsInArray(searches);

				if (searches.length === 5) {
					searches.pop();
				}

				searches.unshift({
					'search': searchedWord,
					'date': Date.now()
				});
				sessionStorage.setItem('searches', JSON.stringify(searches));
			}

			Ajax.post({
				url: '/finder/index',
				responseType: 'json',
				data: {
					searchedWord: searchedWord.toString().trim()
				}
			}).then((response) => {
				Finder.createContent(response);
			}).catch((error) => {});
		} else {
			document.getElementById('panel-message').innerHTML = '';
			RecentSearches.updateState();
		}
	}

	static createContent(response) {
		const panelMessage = document.getElementById('panel-message');
		const artists = response.data.artists;
		const albums = response.data.albums;
		const songs = response.data.songs;

		panelMessage.innerHTML = '';

		if (artists.length || albums.length || songs.length) {
			sessionStorage.setItem('seeAll', true);
			Artist.updateState(artists);
			Album.updateState(albums);
			Song.updateState(songs);
		} else {
			panelMessage.innerHTML = 'No hay resultados disponibles.';
		}
	}
	static resetState() {
		document.getElementById('search').value = '';
		Artist.resetState();
		Album.resetState();
		Song.resetState();
		ResultBox.updateState();
		this.setState({ visible: false });
	}
	static updateState() {
		Finder.resetState();
		this.setState({	visible: true });
	}

	static hide(e) {
		if (e.target.id === 'modal-finder' || e.target.id === 'close-finder') {
			document.getElementById('panel-message').innerHTML = 'Buscar pistas, artistas o albums.';
			Finder.resetState();
		}
	}

	render() {
		return (
			<Modal classes={this.state.visible === true ? 'visible' : ''} clickEventHandler={Finder.hide} id="modal-finder">
				<div className="panel-wrapper-queuelist  panel-search  slideInLeft">
					<div className="panel-queuelist">
						<Header clickEventHandler={Finder.hide} keyUpEventHandler={Finder.findContent}></Header>
					</div>
					<div className="panel-queuelist__content" id="result-box">
						<Artist artists={null}/>
						<Album albums={null}/>
						<Song songs={null}/>
						<RecentSearches />
						<p className="text-center" style={{ color: '#fff' }} id="panel-message">Buscar pistas, artistas o albums.</p>
					</div>
				</div>
			</Modal>
		);
	}
}

export default Finder;
