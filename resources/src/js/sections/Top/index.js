'use strict';

import React from 'react';
import Ajax from '../../Libs/Ajax';
import {Link} from 'react-router-dom';
import Notification from '../../components/Notification/index';
import inFavorites from '../Explorer/components/util';
import ContentSpacing from '../../components/Containers/ContentSpacing';
import MainContent from '../../components/Main/index';
import TrackList from '../components/TrackList';
import { checkXMLHTTPResponse } from '../../app/utils/Utils';
class Top extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			element: <h1>Top 10</h1>
		};

		Top.createContent = Top.createContent.bind(this);
	}

	componentDidMount() {
		Ajax.post({
			url: '/music/top',
			responseType: 'json',
			data: null
		}).then((response) => {
			checkXMLHTTPResponse(response);
			this.setState({
				element: Top.createContent(response)
			});
		}).catch((error) => {
			console.log(error);
		});
	}
	static createContent(response) {
		let element = <Notification
			message={
				<Link to='/user' style={{color: '#fff'}}>
					No hay datos disponibles.
				</Link>
			}
			classes='blue'
		/>;

		if (response.data && response.data.length) {
			let data = response.data;
			let favorites = response.favorites;
			let tracks = [];

			data.forEach((item) => {
				tracks.push({
					id: item.id_cancion,
					src: item.src_audio,
					trackName: item.nombre_cancion,
					duration: item.duracion,
					counter: item.contador,
					srcAlbum: encodeURI(item.src_img),
					artist: `por ${item.nombre_artista}`,
					playlist: false,
					idPlaylist: false,
					favorite: inFavorites(favorites, item.id_cancion),
					inFavoritePage: false
				});
			});

			element = (
				<MainContent>
					<ContentSpacing title="Top 10">
						<div className="album-container">
							<div className="album-container__content">
								<TrackList data={tracks} />
							</div>
						</div>
					</ContentSpacing>
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

export default Top;
