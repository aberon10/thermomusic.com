'use strict';

// Dependencies
import React from 'react';

// Components
import Modal from '../Modal/index';
import Header from './components/header';
import Content from './components/content';
import PlaybackQueue from '../../app/PlaybackQueue/PlaybackQueue';

export default class Queue extends React.Component {
	constructor(props) {
		super(props);

		this.state = {
			list: null,
			visible: false
		};

		Queue.hideQueue = Queue.hideQueue.bind(this);
		Queue.isVisible = Queue.isVisible.bind(this);
		Queue.updateQueue = Queue.updateQueue.bind(this);
		Queue.resetStates = Queue.resetStates.bind(this);
	}

	static isVisible() {
		return this.state.visible;
	}

	static resetStates() {
		this.setState({ list: [], visible: false});
	}

	static updateQueue() {
		this.setState({
			list: (
				<div className="panel-queuelist">
					<Header clickEventHandler={Queue.hideQueue}></Header>
					<Content></Content>
				</div>
			),
			visible: PlaybackQueue.existQueue()
		});

		if (PlaybackQueue.existQueue()) {
			document.body.style.overflowY = 'hidden';
		}
	}

	static hideQueue(e) {
		if (e.target.id === 'modal' || e.target.id === 'close-panel') {
			Queue.resetStates();
			document.body.style.overflowY = 'auto';
		}
	}

	render() {
		return (
			<Modal classes={this.state.visible === true ? 'visible' : ''} clickEventHandler={Queue.hideQueue} id="modal">
				<div className="panel-wrapper-queuelist  slideInRight">
					{this.state.list}
				</div>
			</Modal>
		);
	}
}
