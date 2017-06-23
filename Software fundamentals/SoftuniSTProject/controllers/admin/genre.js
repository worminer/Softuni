const Genre = require('mongoose').model('Genre');

module.exports = {
    all: (req, res) => {
        Genre.find({}).then(genres => {
            res.render('admin/genre/all', {
                subTitle: 'List of all Categories!',
                genres: genres
            });
        })
    },

    createGet: (req, res) => {
        res.render('admin/genre/create',{
            subTitle: 'Create new Genre!'
        })
    },

    createPost: (req, res) => {
        let genreArgs = req.body;

        if (!genreArgs) {
            let errorMsg = 'Genre can not be null';
            genreArgs.error = errorMsg;
            res.render('admin/genre/create', genreArgs);
        } else {
            Genre.create(genreArgs).then(genre => {
                res.redirect('/admin/genre/all');
            })
        }
    },

    editGet: (req, res) => {
        let id = req.params.id;

        Genre.findById(id).then(genre => {
            res.render('admin/genre/edit', {
                subTitle: 'Edit ' + genre.name + ' Genre!',
                genre: genre
            });

        })
    },

    editPost: (req, res) => {
        let id = req.params.id;

        let editArgs = req.body;

        if (!editArgs.name) {
            let errorMsg = 'Genre can not be empty';

            Genre.findById(id).then(genre => {
                res.render('admin/genre/edit', {genre: genre, error: errorMsg});
            });
        } else {
            Genre.findById(id).then(genre => {
                genre.prepareDelete();
                genre.save();
            });

            Genre.findOneAndUpdate({_id: id}, {name: editArgs.name}).then(genre => {
                res.redirect('/admin/genre/all');
            })
        }
    },

    deleteGet: (req, res) => {
        let id = req.params.id;

        Genre.findById(id).then(genre => {
            res.render('admin/genre/delete', {
                subTitle: 'Delete ' + genre.name +' Genre!',
                genre: genre
            });
        })
    },

    deletePost: (req, res) => {
        let id = req.params.id;

        Genre.findOneAndRemove({_id: id}).then(genre => {
            genre.prepareDelete();
            res.redirect('/admin/genre/all');
        });
    }
};