const config = require('./../config/config');
const Movie = require('mongoose').model('Movie');
const Genre = require('mongoose').model('Genre');
const Comment = require('mongoose').model('Comment');
const util = require('./../utilities/utilities');
//TODO: see witch constants are deprecated and remove them!
const initializeTags = require('./../models/Tag').initializeTags;
const imdb = require('imdb-api');


module.exports = {

    searchGet:(req, res) => {
        Genre.find({}).sort('name').then(genre => {
            if (!req.isAuthenticated()) {
                let returnUrl = '/movie/details';
                req.session.returnUrl = returnUrl;

                res.redirect('/user/login');

            }
            //da se dobavi searchPost

            res.render('movie/search',{
                categories: genre
            });
        });


    },
    searchPost: (req, res) => {
        let movieTitle = req.params.movieTitle;

        if(typeof req.body.movieTitle != 'undefined'){
            movieTitle = req.body.movieTitle;
        }
        let currentPage = parseInt(req.params.page);

        if(isNaN(currentPage)){
            currentPage = 1;
        }

        Genre.find({}).sort('name').then(genre => {

            Movie.paginate({'title': { "$regex": movieTitle, "$options": "i" }},{page: currentPage, limit: config.searchConfig.postLimit}).then(pagesInfo => {
                //console.log(pagesInfo);
                let populateQuery = [
                    {path: 'added_by',select: 'fullName'},
                    {path: 'genres',  select: 'name'},
                    {path: 'tags',    select: 'name'}
                ];

                Movie.populate(pagesInfo.docs, populateQuery,(err) => {
                    if(err){
                        console.log(err);
                    }

                    // configuring pagination stuff
                    let previousPage = pagesInfo.page - 1;
                    let nextPage = pagesInfo.page + 1;
                    let isOnFistPage = false;
                    let isOnLastPage = false;

                    if(previousPage < 1)
                    {
                        previousPage = 1;
                    }

                    if(nextPage > pagesInfo.pages)
                    {
                        nextPage = pagesInfo.pages;
                    }

                    if(previousPage == pagesInfo.page){
                        isOnFistPage = true;
                    }
                    if(nextPage == pagesInfo.page){
                        isOnLastPage = true;
                    }

                    let pageArr = [];

                    for (let i = 1; i <= pagesInfo.pages; i++) {
                        pageArr.push(i)
                    }

                    //we limit the character in plot to the configurated limit
                    pagesInfo.docs = util.limitCharsLenInMongooseObj(pagesInfo.docs,'plot',config.globalOptions.plotCharLimit);
                    res.render('movie/search', {
                        subTitle: 'Search movies!', // subTitle
                        movies: pagesInfo.docs, // the movie..
                        movieTitle:movieTitle,
                        categories: genre, // all the categories for the left menu
                        paginationInfo:{                   // all the info needed for pagination
                            totalItems  : pagesInfo.total, // total videos matched
                            itemsLimit  : pagesInfo.limit, // what is the item limit per page
                            currentPage : pagesInfo.page,  // witch is the current page
                            pages       : pagesInfo.pages, // how many pages there are
                            pagesArr    : pageArr,         // array with pages that will be drown as buttons .. this is because handlebars is STUPID!!
                            previousPage : previousPage,   // witch is the previous page
                            nextPage: nextPage,            // witch is the next page
                            isOnFistPage: isOnFistPage,    // is current page the fist page ?
                            isOnLastPage: isOnLastPage     // is current page the last page ?

                        }
                    });
                });

            }).catch((err) => {
                if(err){
                    console.log('movie:search: movies..');
                    console.log(err.message);
                    res.redirect('/movie/search/');
                }
            });

        }).catch((err) => {
            if(err){
                console.log('movie:search: categories');
                console.log(err.message);
                res.redirect('/movie/search/');
            }
        });
    },
    details: (req, res) => {
        let id = req.params.id;
        let populateQuery = [
            {path: 'added_by',select: 'fullName'},
            {path: 'genres',  select: 'name'},
            {path: 'comments',
                populate: {
                    path: 'author'
                }
            },
            {path: 'tags',    select: 'name'}
        ];
        Movie.findById(id).populate(populateQuery).then(movie => {
            for (let i = 0; i < movie.comments.length; i++) {

                let date = new Date(movie.comments[i].dateCreated);  // dateStr you get from mongodb
                //console.log(date.getDate());
                movie.comments[i].formatedDate =
                    date.getFullYear()
                    + '-' +
                    date.getDate()
                    + '-' +
                    date.getDay()
                    + ' ' +
                    date.getHours()
                    + ':' +
                    date.getMinutes()
                    + ':' +
                    date.getSeconds()
                ;

            }


            let subTitle = 'Details for ' + movie.title + ' Movie. ';
            let movies = [];
            movies.push(movie);
            if (!req.user) {
                res.render('movie/details', {
                    subTitle: subTitle,
                    movies: movies,
                    isUserAuthorized: false,
                    showDetailedArticle: true
                });
                return;
            }

            req.user.isInRole('Admin').then(isAdmin => {
                let isUserAuthorized = isAdmin;
                //console.log(isUserAuthorized);
                res.render('movie/details', {
                    subTitle: subTitle,
                    movies: movies,
                    isUserAuthorized: isUserAuthorized,
                    showDetailedArticle: true
                });
            })
        })
    }

};