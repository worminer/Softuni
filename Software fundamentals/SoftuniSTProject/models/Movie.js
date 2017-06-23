const mongoose = require('mongoose');
const mongoosePaginate = require('mongoose-paginate');

let movieSchema = mongoose.Schema(
    {
        title: {type: String, required: true, unique: true},  //title
        plot: {type: String, required: true},   // movie plot
        youtube_trailers: [{type: String , required: true}],
        directors:[{type: String}], // movie directors
        writers:[{type: String}], // movie writers
        actors:[{type: String}], // movie actors
        languages:[{type: String}], // movie languages
        countries:[{type: String}], // movie country
        awards:[{type: String}], // movie awards
        poster_url:{type: String}, // movie url of the poster
        metascore:{type: String}, // movie metascore
        rating:{type: String}, // movie rating
        imdb_users_voted:{type: String}, // movie users voted in imdb
        imdb_id:{type: String}, // movie imdb id
        imdb_url:{type: String}, // movie imdb link
        release_date:{type: String}, // movie release date
        release_year:{type: String}, // movie release year
        rated:{type: String}, // movie rated
        runtime:{type: String}, // movie runtime
        media_type:{type: String}, // is it a movie,tv series or other .. for future filtering much ?
        added_by: {type: mongoose.Schema.Types.ObjectId, required: true, ref: 'User'},  // who added this movie
        genres: [{type: mongoose.Schema.Types.ObjectId, required: true, ref: 'Genre'}], // Genres referenced as genre
        tags: [{type: mongoose.Schema.Types.ObjectId, required: true, ref: 'Tag'}],     //tags
        date: {type: Date, default: Date.now()},// date added in db
        comments: [{type: mongoose.Schema.Types.ObjectId, required: true, ref: 'Comment'}]
    });

movieSchema.plugin(mongoosePaginate);

movieSchema.method({
    prepareInsert: function () {
        let User = mongoose.model('User');
        User.findById(this.added_by).then(user => {

            user.movies.push(this.id);
            user.save();
        }).catch((err) => {
            if(err){
                console.log('Movies:prepare insert -> User');
                console.log(err.message);
            }
        });

        let Genre = mongoose.model('Genre');
        for (let i = 0; i < this.genres.length; i++) {
            let genre = this.genres[i];
            Genre.findById(genre).then(genre => {
                if (genre) {
                    genre.movies.push(this.id);
                    genre.save();
                }
            }).catch((err) => {
                if (err) {
                    console.log('Movies:prepare insert -> Genre');
                    console.log(err.message);
                }
            });
        }

        let Tag = mongoose.model('Tag');
        for (let tagId of this.tags) {
            Tag.findById(tagId).then(tag => {
                if (tag) {
                    tag.movies.push(this.id);
                    tag.save();
                }
            }).catch((err) => {
                if(err){
                    console.log('Movies:prepare insert -> Tag');
                    console.log(err.message);
                }
            });
        }
    },
    prepareDelete: function () {
        let User = mongoose.model('User');
        User.findById(this.author).then(user => {
            if (user) {
                user.movies.remove(this.id);
                user.save();
            }
        }).catch((err) => {
            if(err){
                console.log('Movies:prepare Delete -> user');
                console.log(err.message);
            }
        });

        let Genre = mongoose.model('Genre');
        for (let i = 0; i < this.genres.length; i++) {
            let genre = this.genres[i];
            Genre.findById(genre).then(genre => {
                if (genre) {
                    genre.movies.remove(this.id);
                    genre.save();
                }
            }).catch((err) => {
                if(err){
                    console.log('Movies:prepare Delete -> Genre');
                    console.log(err.message);
                }
            });
        }


        let Tag = mongoose.model('Tag');
        for (let tagId of this.tags) {
            Tag.findById(tagId).then(tag => {
                if (tag) {
                    tag.movies.remove(this.id);
                    tag.save();
                }
            }).catch((err) => {
                if(err){
                    console.log('Movies:prepare Delete -> Tag');
                    console.log(err.message);
                }
            });
        }
    },
    deleteTag: function (tagId) {
        this.tags.remove(tagId);
        this.save();
    }
});

const Movie = mongoose.model('Movie', movieSchema);
module.exports = Movie;