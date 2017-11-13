'use strict';

// Dependencies
import React from 'react';

// Components
import NavBarHeader from './components/NavBarHeader';
import NavBarBody from './components/NavBarBody';
import Ajax from '../../Libs/Ajax';


class Sidebar extends React.Component {
	constructor(props) {
		super(props);
	}
	render() {
		return (
			<div className="nav-bar-container" id="nav-bar-container">
				<nav className="nav-bar">
					<NavBarHeader appName="ThermoMusic" />
					<NavBarBody />
				</nav>
			</div>
		);
	}
}

export default Sidebar;
