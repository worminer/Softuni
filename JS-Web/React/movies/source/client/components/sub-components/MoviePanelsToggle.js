import React from 'react';
import { Link } from 'react-router';

export default class MoviePanelToggles extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className="pull-right btn-group">
                <a className="btn btn-primary"
                   onClick={ this.props.toggleCommentsPanel }>
                    { this.props.showCommentsPanel? 'Hide' : 'Comments' }
                </a>
                <a className="btn btn-primary"
                   onClick={ this.props.toggleVotePanel }>
                    { this.props.showVotePanel? 'Hide' : 'Vote' }
                </a>
                <Link to={`/movie/${ this.props.movieId }/review/add`} className="btn btn-warning">
                    Write review
                </Link>
            </div>
        )
    }
}