'use strict';

import React from 'react';
import { Link } from 'react-router-dom';

import Ajax from '../../Libs/Ajax';

import MainContent from '../../components/Main';
import ContentSpacing from '../../components/Containers/ContentSpacing';
import TrackList from '../../sections/components/TrackList';
import Notification from '../../components/Notification/index';

export default class Favorites extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			element: null
		};

		this.loadData = this.loadData.bind(this);
	}

	componentDidMount() {
		Ajax.post({
			url: '/music/favorites',
			responseType: 'json',
			data: null
		}).then((response) => {
			this.setState({
				element: this.loadData(response)
			});
		}).catch((error) => {
			console.log(error);
		});
	}

	loadData(response) {
		let element = <Notification
			message={
				<Link to='/user' style={{color: '#fff'}}>
					Oops! Al parecer no tienes pistas favoritas. Vamos, animate! de seguro encuentras una que te gusta.
				</Link>
			}
			classes='blue'
		/>;

		if (response.data && response.data.length) {
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
					playlist: null,
					idPlaylist: null,
					favorite: true,
					inFavoritePage: true
				});
			});

			element = (
				<MainContent>
					<ContentSpacing title="Tú Música favorita">
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
			<div>
				{this.state.element}
			</div>
		);
	}
}
