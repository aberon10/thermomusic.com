'use strict';

// Dependencies
import React from 'react';

class ArtistHeader extends React.Component {
	constructor(props) {
		super(props);
	}

	render() {
		return(
			<div className="artist-header" style={{backgroundImage:`url(${encodeURI(this.props.srcImage)})`}}>
				<h1 className="artist-header__name">{this.props.artistName}</h1>			
			</div>
		);
	}
}

export default ArtistHeader;