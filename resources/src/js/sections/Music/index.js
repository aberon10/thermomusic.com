'use strict';

// Dependencies
import React from 'react';

import Ajax from '../../Libs/Ajax';

// Components
import ContentSpacing from '../../components/Containers/ContentSpacing';
import CoverArtist from '../../components/Containers/CoverArtist';
import MainContent from '../../components/Main';
import { stringFromCharCode, checkXMLHTTPResponse } from '../../app/utils/Utils';

export default class Music extends React.Component {
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
		Ajax.post({
			url: '/playlist/get_user_playlists',
			responseType: 'json',
			data: '',
		}).then((response) => {
			checkXMLHTTPResponse(response);
			this._loadData(response);
		}).catch((error) => {
			//console.log(error);
		});
	}

	_loadData(resp) {
		let listItems = [];

		listItems.push({
			id: 0,
			url: '/music/favorites',
			name: 'Favoritos',
			element: <div className="cover-artist-image__improved  bg-alice-dark">
				<i className='cover-artist-icon  icon-heart'></i>
			</div>
		});

		for (let i = 0; i < resp.data.length; i++) {
			listItems.push({
				id: resp.data[i].id_lista,
				url: `${encodeURI('/playlist/index/' + resp.data[i].id_lista)}`,
				name: stringFromCharCode(resp.data[i].nombre_lista),
				element: <div className="cover-artist-image__improved  bg-alice-dark">
					<i className='cover-artist-icon  icon-note'></i>
				</div>
			});
		}

		let element = <MainContent>
			<ContentSpacing title='Tu Música'>
				<CoverArtist data={listItems}></CoverArtist>
			</ContentSpacing>
		</MainContent>;

		this.setState({ element: element });
	}

	render() {
		if (this.state.element) {
			return (
				<div>{this.state.element}</div>
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
