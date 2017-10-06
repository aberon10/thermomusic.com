'use strict';

// Dependencies
import React from 'react';
import { NavLink, Link } from 'react-router-dom';

function closeSidebar() {
	document.getElementById('nav-bar-container').classList.remove('nav-bar-visible');
}

class NavListItems extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		let links = this.props.links;
		let listItems = [];
		let typeLink = this.props.typeLink;

		links.forEach((link, index) => {
			let element = null;
			if (typeLink === '1') {
				element = <a href={link.url} onClick={closeSidebar}>{link.name}</a>;
			} else if (typeLink === '2') {
				element = <Link to={link.url} onClick={closeSidebar}>{link.name}</Link>;
			} else if (typeLink === '3') {
				element = <NavLink to={link.url} onClick={closeSidebar}>{link.name}</NavLink>;
			}

			listItems.push(<li className="nav-list__item" key={index}>{element}</li>);
		});

		return (
			<div>
				{listItems}
			</div>
		);
	}
}
 
NavListItems.defaultProps = {
	typeLink: '1' // Tipo de enlace 1) - <a> 2) - <Link/> 3) - <NavLink/>
};

export default NavListItems;