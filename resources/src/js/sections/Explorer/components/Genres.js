'use strict';

// Dependencies
import React from 'react';
import PropTypes from 'prop-types';

// Components
import ContentSpacing from '../../../components/Containers/ContentSpacing';
import CoverArtist from '../../../components/Containers/CoverArtist';
import MainContent from '../../../components/Main';

const url = '/explorer/index/';

class Genres extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		let data = this.props.data;
		let listItems = [];

		for (let i = 0; i < data.length; i++) {
			listItems.push({
				id: data[i][0].id_genero,
				url: `${encodeURI(url+data[i][0].id_genero)}`,
				src: encodeURI(data[i][0].src_img),
				name: data[i][0].nombre_genero
			});
		}		

		return (
			<MainContent>
				<ContentSpacing title="Géneros Musicales">
					<CoverArtist data={listItems}/>
				</ContentSpacing>
			</MainContent>
		);
	}
}

Genres.propTypes = {
	data: PropTypes.array.isRequired
};

export default Genres;