'use strict';

// Dependencies
import React from 'react';
import PropTypes from 'prop-types';

// Components
import ContentSpacing from '../../components/Containers/ContentSpacing';
import CoverArtist from '../../components/Containers/CoverArtist';
import TrackList from './TrackList';

class ArtistMusic extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<section className="artist-music">
				<div className="artist-music__header">
					<ContentSpacing title='Canciones Populares'>
						<TrackList data={this.props.tracks}/>
					</ContentSpacing>
				</div>
				<div className="artist-music__content">
					<ContentSpacing title='Álbumes'>
						<CoverArtist data={this.props.albums}/>
					</ContentSpacing>
				</div>
			</section>
		);
	}
}

export default ArtistMusic;