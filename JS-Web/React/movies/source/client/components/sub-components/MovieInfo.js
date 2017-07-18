import React from 'react';
import { Link } from 'react-router';

export default class MovieInfo extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        let genres = this.props.movie.genres.map(genre => {
            return (
                <strong key={ this.props.movie._id + genre }>{ genre } </strong>
            );
        });

        return(
            <div className='media-body'>
                <h4 className='media-heading'>
                    <Link to={`/movie/${ this.props.movie._id }/${ this.props.movie.name }`}>
                        { this.props.movie.name }
                    </Link>
                </h4>
                <small>Genres: { genres }</small>
                <br />
                <p>{ this.props.movie.description }</p>
                <span className="votes">Votes:
                    <strong> { this.props.votesAmount }</strong>
                </span>
            </div>
        )
    }
}