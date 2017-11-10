'use strict';

// Dependencies
import React from 'react';
import PropTypes from 'prop-types';
import { Link } from 'react-router-dom';

// Config
import Config from '../../config';

import { substr } from '../../components/utils';

class CoverArtist extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		let data = Array.prototype.slice.call(this.props.data);
		let listItems = [];

		data.forEach((item, index) => {
			let coverArtistFooter = null;
			let coverArtisHeader = null;

			if (item.element) {
				coverArtisHeader = item.element;
			} else {
				coverArtisHeader = (
					<div className="cover-artist-image"
						style={{ backgroundImage: `url(${Config.urlResource + '/' + item.src})` }}>
					</div>
				);
			}

			if (item.album) {
				coverArtistFooter = (
					<div className="album-info">
						<h3 className="album-info__name">{substr(item.name, 20)}</h3>
						<p className="album-info__artist">{substr(item.artist, 20)}</p>
						<p className="album-info__year">{item.albumInfo}</p>
					</div>
				);
			} else {
				coverArtistFooter = (
					<Link to={item.url} className="cover-artist-name">{substr(item.name, 20)}</Link>
				);
			}

			listItems.push(
				<div key={item.id} className={item.album ? 'cover-artist' : 'cover-artist  brightness-image'}>
					<div className="cover-artist__header">
						{item.album == true ? (
							<div>{coverArtisHeader}</div>
						) : (
							<Link to={item.url}>
								{coverArtisHeader}
							</Link>
						)}
					</div>
					<div className="cover-artist__footer">
						{coverArtistFooter}
					</div>
				</div>
			);
		});

		return (
			<div className="cover-artist-container">
				{listItems}
			</div>
		);
	}
}

CoverArtist.propTypes = {
	data: PropTypes.array.isRequired
};

export default CoverArtist;

