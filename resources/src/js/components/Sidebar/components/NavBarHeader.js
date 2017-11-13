'use strict';

// Dependencies
import React from 'react';
import {Link} from 'react-router-dom';

import Finder from '../../Finder/index';
import Ajax from '../../../Libs/Ajax';
import { substr } from '../../utils';

function toggleNavBar(e) {
	e.preventDefault();
	let navBar = document.getElementById('nav-bar-container');

	if (navBar.classList.contains('nav-bar-visible')) {
		navBar.classList.remove('nav-bar-visible');
	} else {
		navBar.classList.add('nav-bar-visible');
	}
}

function openFinder() {
	Finder.updateState();
}

class NavBarHeader extends React.Component {
	constructor(props) {
		super(props);
		this.state = {
			currentUser: 'user',
			src: ''
		};
	}

	componentDidMount() {
		Ajax.post({
			url: '/user/get_data',
			responseType: 'json',
			data: null
		}).then((response) => {
			if (response) {
				this.setState({
					currentUser: response.data['usuario'],
					src: response.img
				});
			}
		}).catch((error) => {});
	}

	render() {
		const avatar = this.state.src !== '' ? <img src={this.state.src} style={{ width: '50px', height: '50px'}}/> : <i className="icon-user"></i>;
		return (
			<div className="nav-bar__header">
				<div className="nav-bar__logo">
					<Link to='/user'><h2>{this.props.appName}</h2></Link>
					<div className="floating-nav-bar">
						<i className="icon-search  action-button" onClick={openFinder}></i>
						<i className="icon-ellipsis-v  action-button  floating-action-button" onClick={toggleNavBar}></i>
					</div>
				</div>
				<div className="nav-bar__session-info  group">
					<Link to="/user/account" className="center">
						{avatar} <p>{substr(this.state.currentUser, 28)}</p>
					</Link>
				</div>
				<div className="nav-bar__search  group">
					<a href="#" onClick={openFinder}>Buscar</a>
					<i className="icon-search" onClick={openFinder}></i>
				</div>
			</div>
		);
	}
}

NavBarHeader.defaultProps = {
	appName: 'Application',
	currentUser: 'user'
};

export default NavBarHeader;
