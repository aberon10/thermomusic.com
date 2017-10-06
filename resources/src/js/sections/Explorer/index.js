'use strict';

// Dependencies
import React from 'react';

// Libs
import Ajax from '../../Libs/Ajax';

// Components
import MainContent from '../../components/Main';
import Notification from '../../components/Notification';
import Genres from './components/Genres';
import Artists from './components/Artists';
import Artist from './components/Artist';
import Album from './components/Album';

class Explorer extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			element: null
		};

		this._updateState = this._updateState.bind(this);
		this._loadData = this._loadData.bind(this);
	}

	componentDidMount() { 
		this._updateState();
	}
	
	componentWillReceiveProps() { 
		this._updateState();
	}

	_updateState() {
		let params = this.props.match.params;
		let dataRequest = {
			url: '/explorer/genres',
			data: {
				csrf: document.querySelector('meta[name="csrf-token"]').content
			},
			reponseType: 'json'
		};
		
		if (params.id_genre) {
			dataRequest.url = '/artist/get_artist_by_genre';
			dataRequest.data.genre = params.id_genre;
		} else if (params.id_artist) {
			dataRequest.url = '/artist/content';
			dataRequest.data.artist = params.id_artist;
		} else if (params.id_album) {
			dataRequest.url = '/album/content';
			dataRequest.data.album = params.id_album;
		}

		Ajax.post(dataRequest)
			.then((response) => {
				this._loadData(response);
			}).catch((error) => {
				console.log(error);
			});	
	}

	_loadData(resp) {
		let params = this.props.match.params;
		let result = JSON.parse(resp);
		let element = <Notification message={result.message} classes='blue' />;

		if (result.data) {
			let data = Object.keys(result.data).map(key => [result.data[key]]);
			
			if (Object.keys(params).length === 0) {
				element = <Genres data={data}/>;
			} else if (params.id_genre) {
				element = <Artists data={data}/>;
			} else if (params.id_artist && data.length >= 2) {
				element = <Artist data={data}/>;
			} else if (params.id_album) {
				element = <Album data={data}/>;
			}	
		}

		this.setState({
			element: element
		});
	}
	
	render() {
		if (this.state.element) {
			return (
				<div>
					{this.state.element}
				</div>
			);			
		} else {
			/*
				TODO:
				AGREGAR UN LOADING...
			 */
			return (		
				<MainContent>	
					<div>Loading...</div>
				</MainContent>
			);
		}
	}
}

export default Explorer;