'use strict';

// Dependencies
import React from 'react';

import Ajax from '../../Libs/Ajax';

// Components
import Modal from '../Modal/index';
import Artist from './components/Artist';
import Album from './components/Album';
import Song from './components/Song';
import Finder from './index';
import { substr } from '../utils';

class ResultBox extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			visible: false,
			element: null,
			title: null
		};

		ResultBox.resetState = ResultBox.resetState.bind(this);
		ResultBox.updateState = ResultBox.updateState.bind(this);
		ResultBox.findContent = ResultBox.findContent.bind(this);
		ResultBox.createContent = ResultBox.createContent.bind(this);
	}

	static resetState() {
		this.setState({
			visible: false,
			element: null,
			title: null
		});
		Finder.resetState();
	}

	static updateState() {
		this.setState({
			visible: false,
			element: null,
			title: null
		});
	}

	static findContent(e) {
		let entitie = e.target.dataset.entitie;
		let search = e.target.dataset.search;

		Ajax.post({
			url: '/finder/index',
			responseType: 'json',
			data: {
				searchedWord: search.toString().trim(),
				entitie: entitie
			}
		}).then((response) => {
			ResultBox.createContent(response);
		}).catch((error) => {});
	}

	static createContent(response) {
		sessionStorage.removeItem('seeAll');
		let element = null;

		if (response && response.data.data.length) {
			if (response.entitie === 'artist') {
				element = <Artist artists={response.data.data} seeAll='false'/>;
			} else if (response.entitie === 'album') {
				element = <Album albums={response.data.data}  seeAll='false'/>;
			} else if (response.entitie === 'song') {
				element = <Song songs={response.data.data}  seeAll='false'/>;
			}
		}

		this.setState({
			element: element,
			title: `Mostrando resultados para: ${substr(response.search, 25)}`,
			visible: true
		});
	}

	static hide(e) {
		if (e.target.id === 'modal-resultbox' || e.target.id === 'close-resultbox') {
			ResultBox.updateState();
		}
	}
	render() {
		return (
			<Modal classes={this.state.visible === true ? 'visible' : ''} clickEventHandler={ResultBox.hide} id="modal-resultbox">
				<div className="panel-wrapper-queuelist  panel-search  slideInLeft">
					<div className="panel-queuelist">
						<div className="panel-queuelist__header">
							<div className="panel-headings">
								<h3 className="text-left" style={{ color: '#fff' }}>{this.state.title}</h3>
							</div>
							<span className="icon-close  panel-button  panel-button__close" id="close-resultbox" onClick={ResultBox.hide}></span>
						</div>
					</div>
					<div className="panel-queuelist__content" id="result-box">
						{this.state.element}
					</div>
				</div>
			</Modal>
		);
	}
}

export default ResultBox;
