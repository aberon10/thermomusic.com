'use strict';

// Dependencies
import React from 'react';
import { Link } from 'react-router-dom';

import {substr} from '../../utils';
import Finder from '../index';
import ResultBox from '../ResultBox';
export default class Album extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			element: null
		};

		Album.updateState = Album.updateState.bind(this);
		Album.resetState = Album.resetState.bind(this);
		Album.createContent = Album.createContent.bind(this);
	}

	static resetState() {
		this.setState({ element: null });
	}

	static updateState(albums) {
		this.setState({ element: Album.createContent(albums) });
	}

	static createContent(albums) {
		let albumsElements = [];
		let element = null;
		let LinkSeeAll = null;
		let onClickEventHandler = this.state.element ? ResultBox.resetState : Finder.resetState;

		if (albums && albums.length) {
			albums.forEach((album) => {
				albumsElements.push(
					<div className="card-item" key={album.id_album}>
						<div className="card-picture">
							<figure className="thumbnail">
								<Link to={'/album/index/' + album.id_album} onClick={onClickEventHandler}>
									<img src={'http://thermobackend.com/storage/' + album.src_img}
										alt={album.nombre} />
								</Link>
							</figure>
						</div>
						<div className="card-info">
							<Link to={'/album/index/' + album.id_album} onClick={onClickEventHandler}>
								<h2 className="card-info__heading-2">{substr(album.nombre)}</h2>
							</Link>
							<Link to={'/artist/index/' + album.id_artista} onClick={onClickEventHandler}>
								<h3 className="card-info__heading-3">por {substr(album.nombre_artista)}</h3>
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
				data-entitie='album'
				data-search={document.getElementById('search').value}
			>ver todos</span>;
		}

		if (albumsElements.length) {
			element = <div className="card-group">
				<h3 className="card-group-title">Albums</h3>
				<div className="card-list">
					{albumsElements}
				</div>
				{LinkSeeAll}
			</div>;
		}

		return element;
	}

	render() {
		let element = this.props.albums ? Album.createContent(this.props.albums) : this.state.element;
		return (
			<div>
				{element}
			</div>
		);
	}
}

Album.defaultProps = {
	albums: null
};
