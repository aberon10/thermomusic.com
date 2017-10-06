'use strict';

// Dependencies
import React from 'react';
import PropTypes from 'prop-types';

// Components
import ArtistHeader from '../../components/ArtistHeader';
import ArtistMusic from '../../components/ArtistMusic';
import MainContent from '../../../components/Main';

// Config
import Config from '../../../config';

const url = '/album/index/';

class Artist extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		let albums = [];
		let tracks = [];		
		let data = this.props.data;
		let artistName = data[0][0].nombre_artista;
		let bgArtistHeader= Config.urlResource + '/' + data[0][0].src_img;
		let dataAlbums = Object.keys(data[1][0]).map(key => [data[1][0][key]]);
		let dataTracks = Object.keys(data[2][0]).map(key => [data[2][0][key]]);

		// albums
		for (let i = 0; i < dataAlbums.length; i++) {
			albums.push({
				id: dataAlbums[i][0].id_album,
				url: `${encodeURI(url+dataAlbums[i][0].id_album)}`,
				src: encodeURI(dataAlbums[i][0].image),
				name: dataAlbums[i][0].nombre,
				album: false
			});
		}

		// tracks
		dataTracks.forEach((item, index) => {
			tracks.push({
				id: dataTracks[index][0].id_cancion,
				src: dataTracks[index][0].src_audio,
				duration: dataTracks[index][0].duracion,
				trackName: dataTracks[index][0].nombre_cancion,
				counter: dataTracks[index][0].contador,
				artist: `por ${artistName}`,
				srcAlbum: dataTracks[index][0].src_img
			});
		});

		return (
			<div>
				<ArtistHeader artistName={artistName} srcImage={bgArtistHeader} />
				<MainContent>
					<ArtistMusic albums={albums} tracks={tracks}/>
				</MainContent>
			</div>
		);
	}
}

Artist.propTypes = {
	data: PropTypes.array.isRequired
};

export default Artist;