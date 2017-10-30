'use strict';

import React from 'react';

import { removeClassModal, onSubmit } from './utils';

export default class ModalForm extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return (
			<div className="modal-dialog  modal-dark" id="modal-form-playlist">
				<div className="dialog-container  dialog-form-album">
					<div className="dialog-header">
						<i className="icon-close  dialog-header__icon" id="close-dialog" onClick={removeClassModal} data-id-modal="modal-form-playlist"></i>
					</div>
					<div className="dialog-content">
						<section className="content-spacing">
							<div className="content-spacign__header">
								<h1 className="content-spacing-title">Crear nueva playlist</h1>
							</div>
							<div className="content-spacing__body">
								<form action="#" name="form-playlist" id="form-playlist" onSubmit={onSubmit}>
									<div className="input-group">
										<input type="text" className="form-control" name="playlistname" id="playlistname" maxLength="100" placeholder="Escribe el nombre aquí..." />
										<div className="error-message"></div>
									</div>
									<div className="input-group">
										<button type="submit" className="button button-small button-cyan radius button-big button-scale" id="add-playlist">crear</button>
									</div>
								</form>
							</div>
						</section>
					</div>
				</div>
			</div>
		);
	}
}
