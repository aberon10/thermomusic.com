'use strict';

import React from 'react';
import { Link } from 'react-router-dom';

function clearHistory() {
	sessionStorage.removeItem('searches');
	RecentSearches.updateState();
}

function executeSearch(e) {
	e.preventDefault();
	let input = document.getElementById('search');
	let ev = document.createEvent('KeyboardEvent');
	input.value = e.target.innerHTML;

	// Send key '13' (= enter)
	ev.initKeyEvent(
		'keyup', true, true, window, false, false, false, false, 13, 0);
	input.dispatchEvent(ev);
}


class RecentSearches extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			visible: false,
			element: null
		};

		RecentSearches.updateState = RecentSearches.updateState.bind(this);
		RecentSearches.resetState = RecentSearches.resetState.bind(this);
		RecentSearches.createSearchList = RecentSearches.createSearchList.bind(this);
	}

	static resetState() {
		this.setState({
			visible: false,
			element: null
		});
	}
	static createSearchList() {
		let searches = sessionStorage.getItem('searches');
		let element = null;

		if (searches) {
			searches = JSON.parse(searches);
			let items = [];

			searches.searches.forEach((element, index) => {
				items.push(
					<li className="nav-list__item" key={index}>
						<Link to="#" className="nav-list__link" onClick={executeSearch}>{element}</Link>
					</li>
				);
			});

			element = <div className="recently-searches">
				<h3 className="recently-searches__title">Busquedas recientes: </h3>
				<ul className="nav-list  recently-searches__list">
					{items}
				</ul>
				<span className="see-all" onClick={clearHistory}>Limpiar historial</span>
			</div>;
		}
		return element;
	}

	static updateState() {
		this.setState({
			visible: false,
			element: RecentSearches.createSearchList()
		});
	}

	render() {
		return (
			<div>
				{this.state.element}
			</div>
		);
	}
}

export default RecentSearches;
