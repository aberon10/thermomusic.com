'use strict';

// Dependencies
import React from 'react';
import {Link} from 'react-router-dom';

import Finder from '../../Finder/index';

function toggleNavBar(e) {
	e.preventDefault();
	let navBar = document.getElementById('nav-bar-container');

	if (navBar.classList.contains('nav-bar-visible')) {
		navBar.classList.remove('nav-bar-visible');
	} else {
		navBar.classList.add('nav-bar-visible')
	}
}

function openFinder() {
	Finder.updateState();
}

class NavBarHeader extends React.Component {
	constructor(props) {
		super(props);
	}
	render() {
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
					<Link to="/user/account">
						<i className="icon-user"></i> {this.props.currentUser}
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
