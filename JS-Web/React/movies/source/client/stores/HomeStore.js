import alt from '../alt';
import HomeActions from '../actions/HomeActions';

class HomeStore {
    constructor() {
        this.bindActions(HomeActions);

        this.topTenMovies = [];
    }

    onGetTopTenMoviesSuccess(movies) {
        this.topTenMovies = movies;
    }

    onGetTopTenMoviesFail(err) {
        console.log('Could connect to DB', err);
    }
}

export default alt.createStore(HomeStore);
