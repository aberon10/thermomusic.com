'use strict';

// Dependencies
import React from 'react';
import PropTypes from 'prop-types';

// Components
import ContentSpacing from '../../../components/Containers/ContentSpacing';
import CoverArtist from '../../../components/Containers/CoverArtist';
import MainContent from '../../../components/Main';

const url = '/artist/index/';

class Artists extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		let data = this.props.data;
		let listItems = [];

		for (let i = 0; i < data.length; i++) {
			listItems.push({
				id: data[i][0].id_artista,
				url: `${encodeURI(url+data[i][0].id_artista)}`,
				src: encodeURI(data[i][0].src_img),
				name: data[i][0].nombre_artista
			});
		}		

		return (
			<MainContent>
				<ContentSpacing title={data[0][0].nombre_genero}>
					<CoverArtist data={listItems}/>
				</ContentSpacing>
			</MainContent>
		);
	}
}

Artists.propTypes = {
	data: PropTypes.array.isRequired
};

export default Artists;