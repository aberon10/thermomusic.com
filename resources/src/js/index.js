'use strict';

// Dependencies
import React from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter as Router } from 'react-router-dom';

// Components
import App from './routes';

const app = document.getElementById('app');

ReactDOM.render(
	<Router>
		<App/>
	</Router>,
	app
);