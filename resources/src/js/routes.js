'use strict';

// Dependencies
import React from 'react';
import { Route, Switch } from 'react-router-dom';

// Components
import Sidebar from './components/Sidebar/index';
import Player from './components/Player/index';
import FloatingPlayer from './components/Player/FloatingPlayer';
import Queue from './components/Queue/index';
import MenuPopUp from './components/MenuPopUp/index';
import Explorer from './sections/Explorer/index';
import Music from './sections/Music/index';
import Page404 from './sections/Page404/index';

const routes = [
	{
		path: '/user',
		exact: true,
		component: Explorer
	},
	{
		path: '/user/index',
		exact: true,
		component: Explorer
	},
	{
		path: '/explorer',
		exact: true,
		component: Explorer
	},
	{
		path: '/explorer/index',
		exact: true,
		component: Explorer
	},
	{
		path: '/explorer/index/:id_genre',
		exact: true,
		component: Explorer
	},
	{
		path: '/artist/index/:id_artist',
		exact: true,
		component: Explorer
	},
	{
		path: '/album/index/:id_album',
		exact: true,
		component: Explorer
	},
	{
		path: '/music',
		exact: false,
		component: Music
	},
	{
		path: null,
		exact: false,
		component: Page404
	}
];

class App extends React.Component {
	render() {
		return (
			<div>
				<Switch>
					{routes.map((route, index) => (
						<Route key={index} exact={route.exact} path={route.path} component={route.component}/>
					))}
				</Switch>
				<div className="App">
					<Sidebar/>
				</div>
				<Player/>
				<FloatingPlayer/>
				<Queue/>
				<MenuPopUp/>
			</div>
		);
	}
}

export default App;
