'use strict';

// Dependencies
import React from 'react';

// Components
import MainContent from '../../../components/Main';
import TrackList from '../../components/TrackList';
import CoverArtist from '../../../components/Containers/CoverArtist';

import inFavorites from './util';

class Album extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		let data = this.props.data;
		let favorites = this.props.favorites;
		let tracks = [];

		let album = [{
			album: true,
			id: data[0][0].id_album,
			src: encodeURI(data[0][0].src_img),
			name: data[0][0].nombre,
			artist: `por ${data[0][0].nombre_artista}`,
			albumInfo: `Año ${data[0][0].anio} - ${data[0][0].cant_pistas} Pistas`
		}];

		data.forEach((item) => {
			tracks.push({
				id: item[0].id_cancion,
				src: item[0].src_audio,
				trackName: item[0].nombre_cancion,
				duration: item[0].duracion,
				counter: item[0].contador,
				srcAlbum: encodeURI(data[0][0].src_img),
				artist: `por ${data[0][0].nombre_artista}`,
				playlist: false,
				idPlaylist: false,
				favorite: inFavorites(favorites, item[0].id_cancion),
				inFavoritePage: false
			});
		});

		return(
			<MainContent>
				<div className="album-container">
					<div className="album-container__image">
						<CoverArtist data={album} />
					</div>
					<div className="album-container__content">
						<TrackList data={tracks}/>
					</div>
				</div>
			</MainContent>
		);
	}
}

export default Album;
