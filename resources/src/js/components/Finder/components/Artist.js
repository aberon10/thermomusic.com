'use strict';

// Dependencies
import React from 'react';
import { Link } from 'react-router-dom';

import { substr } from '../../utils';
import Finder from '../index';
import ResultBox from '../ResultBox';

export default class Artist extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			element: null
		};

		Artist.updateState = Artist.updateState.bind(this);
		Artist.resetState = Artist.resetState.bind(this);
		Artist.createContent = Artist.createContent.bind(this);
	}

	static resetState() {
		this.setState({ element: null });
	}

	static createContent(artists) {
		let artistsElements = [];
		let element = null;
		let LinkSeeAll = null;
		let onClickEventHandler = this.state.element ? ResultBox.resetState : Finder.resetState;

		if (artists && artists.length) {
			artists.forEach((artist) => {
				artistsElements.push(
					<div className="card-item" key={artist.id_artista}>
						<div className="card-picture">
							<figure className="thumbnail">
								<Link to={'/artist/index/' + artist.id_artista} onClick={onClickEventHandler}>
									<img src={'http://thermobackend.com/storage/' + artist.src_img}
										alt={artist.nombre_artista} />
								</Link>
							</figure>
						</div>
						<div className="card-info">
							<Link to={'/artist/index/' + artist.id_artista} onClick={onClickEventHandler}>
								<h2 className="card-info__heading-2">{substr(artist.nombre_artista)}</h2>
							</Link>
							<Link to={'/explorer/index/' + artist.id_genero} onClick={onClickEventHandler}>
								<h3 className="card-info__heading-3">{substr(artist.nombre_genero)}</h3>
							</Link>
						</div>
					</div>
				);
			});
		}

		if (sessionStorage.getItem('seeAll')) {
			LinkSeeAll = <span to='#'
				className="see-all"
				onClick={ResultBox.findContent}
				style={{ cursor: 'pointer' }}
				data-entitie='artist'
				data-search={document.getElementById('search').value}
			>ver todos</span>;
		}

		if (artistsElements.length) {
			element = <div className="card-group">
				<h3 className="card-group-title">Artistas</h3>
				<div className="card-list">
					{artistsElements}
				</div>
				{LinkSeeAll}
			</div>;
		}

		return element;
	}

	static updateState(artists) {
		this.setState({ element: Artist.createContent(artists) });
	}

	render() {
		let element = this.props.artists ? Artist.createContent(this.props.artists) : this.state.element;
		return (
			<div>
				{element}
			</div>
		);
	}
}

Artist.defaultProps = {
	artists: null
};
