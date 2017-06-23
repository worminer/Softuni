const mongoose = require('mongoose');
const mongoosePaginate = require('mongoose-paginate');

let genreSchema = mongoose.Schema({
    name: {type: String, required: true, unique: true},
    movies: [{type: mongoose.Schema.Types.ObjectId, ref: 'Movie'}]
});

genreSchema.method({
    prepareInsert: function () {
        let Movie = mongoose.model('Movie');
        for (let movie of this.movies) {
            Movie.findById(movie).then(movie => {
                if (movie.genres.indexOf(this.id) === -1) {
                    movie.genres.push(this.id);
                    movie.save();
                }
            }).catch((err) => {
                if(err){
                    console.log('Genres:prepare insert -> movie');
                    console.log(err.message);
                }
            });
        }
    },
    prepareDelete: function () {
        let Movie = mongoose.model('Movie');
        for (let movie of this.movies) {
            Movie.findById(movie).then(movie => {
                movie.prepareDelete();
                movie.remove();
            }).catch((err) => {
                if(err){
                    console.log('Genres:prepare Delte -> Movie');
                    console.log(err.message);
                }
            });
        }
    }
});
genreSchema.plugin(mongoosePaginate);

genreSchema.set('versionKey', false);

const Genre = mongoose.model('Genre', genreSchema);
module.exports = Genre;

module.exports.seedGenres = () => {
    genreSeeds = [
        "Action",
        "Comedy",
        "Family",
        "History",
        "Mystery",
        "Sci-Fi",
        "War",
        "Western",
        "Adventure",
        "Crime",
        "Fantasy",
        "Horror",
        "Thriller"
    ];
    for (let i = 0; i < genreSeeds.length; i++) {
        let currentGenre = genreSeeds[i];
        Genre.findOne({name: currentGenre}).then(genre => {
            if (!genre) {
                let genreData = {
                    name: currentGenre,
                    movies: []
                };

                Genre.create(genreData).then(genre => {
                  console.log(`Genre -> "${currentGenre}" seeded!`);
                }).catch((err) => {
                    if(err){
                        console.log(err.message);
                    }
                });
            }
        }).catch((err) => {
            if(err){
                console.log(err.message);
            }
        });
    }
};
module.exports.initializeGenres = function (genres, movieId) {
    for (let genre of genres) {
        if (genre) {
            Genre.findOne({name: genre}).then(genreObj => {
                // If is existing - insert movie in it
                if (genreObj) {
                    if (genreObj.movies.indexOf(movieId) === -1) {
                        genreObj.movies.push(movieId);
                        genreObj.prepareInsert();
                        genreObj.save();
                    }
                } else {
                    Genre.create({name: genre}).then(genreObj => {
                        genreObj.movies.push(movieId);
                        genreObj.prepareInsert();
                        genreObj.save();
                    }).catch((err) => {
                        if(err){
                            console.log('Genres:Initialize Genres -> create');
                            console.log(err.message);
                        }
                    });
                }
            }).catch((err) => {
                if(err){
                    console.log('Genres:Initialize Genres -> find');
                    console.log(err.message);
                }
            });
        }
    }
};