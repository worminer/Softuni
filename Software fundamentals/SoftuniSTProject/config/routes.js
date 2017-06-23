const homeController = require('./../controllers/home');
const adminController = require('./../controllers/admin/admin');
const userController = require('./../controllers/user');
const movieController = require('./../controllers/movie');
const tagController = require('./../controllers/tag');
const commentController = require('./../controllers/comment');

module.exports = (app) => {

    app.get('/', homeController.index); // Public slow home page

    app.get('/genre/:id', homeController.listGenreMovies); // Public search by genre
    app.get('/genre/:id/:page', homeController.listGenreMovies); // Public search by genre and page number

    app.get('/user/register', userController.registerGet);   // Public show registration form
    app.post('/user/register', userController.registerPost); // Public register new user

    app.get('/user/login', userController.loginGet); // Public get login page
    app.post('/user/login', userController.loginPost); // Public login the user

    app.get('/user/logout', userController.logout); // Public logout

    app.get('/tag/:name', tagController.lisMoviesByTag); // Public Search by tag name!
    app.get('/tag/:name/:page', tagController.lisMoviesByTag); // Public Search by tag name! and page number


    app.get('/movie/details/:id', movieController.details); // Public movie detail


    app.get('/home/about',homeController.about);

    app.get('/home/contact',homeController.contact);


    app.get('/movie/search',movieController.searchGet);
    app.get('/movie/search/:movieTitle/:page',movieController.searchPost);
    app.post('/movie/search',movieController.searchPost);

//comment controller staff
    app.get('/comment/create/:id',commentController.commentGet);
    app.post('/comment/create/:id',commentController.commentPost);

    app.get('/comment/all/:id',commentController.allGet);


// middleware that allows only admins to work with those routes
    app.use((req, res, next) => {
        if (req.isAuthenticated()) {
            req.user.isInRole('Admin').then(isAdmin => {
                if (isAdmin) {
                    next();
                } else {
                    res.redirect('/');
                }
            })
        } else {
            res.redirect('/user/login');
        }
    });

    // movie controller stuff
    app.get('/admin/movie/all/', adminController.movie.showAll);
    app.get('/admin/movie/imdb/', adminController.movie.imdbIndexGet);

    app.get('/admin/movie/imdb/name/', adminController.movie.imdbIndexGet);
    app.post('/admin/movie/imdb/name/', adminController.movie.imdbByNamePost);

    app.get('/admin/movie/imdb/id/', adminController.movie.imdbIndexGet);
    app.post('/admin/movie/imdb/id/', adminController.movie.imdbByIdPost);

    app.get('/admin/movie/create', adminController.movie.createGet);
    app.post('/admin/movie/create', adminController.movie.createPost);

    app.get('/admin/movie/edit/:id', adminController.movie.editGet);
    app.post('/admin/movie/edit/:id', adminController.movie.editPost);

    app.get('/admin/movie/delete/:id', adminController.movie.deleteGet);
    app.post('/admin/movie/delete/:id', adminController.movie.deletePost);

    //user controller stuff
    app.get('/admin/user/all', adminController.user.all);

    app.get('/admin/user/edit/:id', adminController.user.editGet);
    app.post('/admin/user/edit/:id', adminController.user.editPost);

    app.get('/admin/user/delete/:id', adminController.user.deleteGet);
    app.post('/admin/user/delete/:id', adminController.user.deletePost);

    //category controller stuff
    app.get('/admin/genre/all', adminController.genre.all);

    app.get('/admin/genre/create', adminController.genre.createGet);
    app.post('/admin/genre/create', adminController.genre.createPost);

    app.get('/admin/genre/edit/:id', adminController.genre.editGet);
    app.post('/admin/genre/edit/:id', adminController.genre.editPost);

    app.get('/admin/genre/delete/:id', adminController.genre.deleteGet);
    app.post('/admin/genre/delete/:id', adminController.genre.deletePost);


};