const mongoose = require('mongoose');

let commentSchema = mongoose.Schema({
    author: {type:  mongoose.Schema.Types.ObjectId, required: true, ref: 'User'},
    about: {type:  mongoose.Schema.Types.ObjectId, required: true, ref: 'Movie'},//movie id
    content: {type: String,required: true},
    dateCreated: {type: Date, default: Date.now()}
});
commentSchema.method({
    prepareInsert: function () {
        let Movie = require('mongoose').model('Movie');
        Movie.findById(this.about).then(movie => {
            if(movie){
                movie.comments.push(this.id);
                movie.save()
            }
        })
    },
    prepareDelete: function () {
        let Movie = require('mongoose').model('Movie');
        Movie.findById(this.about).then(movie => {
            if(movie){
                movie.comments.remove(this.id);
                movie.save()
            }
        })
    }
});

commentSchema.set('versionKey', false);

const Comment = mongoose.model('Comment', commentSchema);

module.exports = Comment;