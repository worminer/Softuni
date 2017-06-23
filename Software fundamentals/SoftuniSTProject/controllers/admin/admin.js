const userController = require('./user');
const genreController = require('./genre');
const movieController = require('./movie');
module.exports = {
    user: userController,
    genre: genreController,
    movie: movieController

};
