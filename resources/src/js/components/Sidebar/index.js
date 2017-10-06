'use strict';

// Dependencies
import React from 'react';

// Components
import NavBarHeader from './components/NavBarHeader';
import NavBarBody from './components/NavBarBody';

class Sidebar extends React.Component {
	/*componentDidMount() {
		//document.querySelector('.nav-bar a.active').classList.remove('active');
		//document.querySelector("a[href='"+window.location.pathname+"']").classList.add('active');
	}*/

	render() {
		return (
			<div className="nav-bar-container" id="nav-bar-container">
				<nav className="nav-bar">
					<NavBarHeader appName="ThermoMusic" currentUser="user" />
					<NavBarBody />
				</nav>
			</div>
		);
	}
}

export default Sidebar;