'use strict';

// Dependencies
import React from 'react';

// Components
import Modal from '../Modal/index';
import Header from './components/Header';
import Ajax from '../../Libs/Ajax';
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

		// TODO:
		// Busqueda Normal
		// Busqueda Avanzada
		if (searchedWord) {
			if (code === 13) {
				// Guardamos la búsqueda
				let searches = sessionStorage.getItem('searches');

				if (searches) {
					searches = JSON.parse(searches);
				} else {
					searches = {searches: []};
				}

				if (searches.searches.indexOf(searchedWord) === -1) {
					searches.searches.push(searchedWord);
					sessionStorage.setItem('searches', JSON.stringify(searches));
				}
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
			RecentSearches.updateState();
		}
	}

	static createContent(response) {
		const artists = response.data.artists;
		const albums = response.data.albums;
		const songs = response.data.songs;

		sessionStorage.setItem('seeAll', true);
		Artist.updateState(artists);
		Album.updateState(albums);
		Song.updateState(songs);
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
					</div>
				</div>
			</Modal>
		);
	}
}

export default Finder;
