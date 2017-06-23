const config = require('./../config/config');
const mongoose = require('mongoose');
const Movie = mongoose.model('Movie');
const User = mongoose.model('User');
const Genre = mongoose.model('Genre');
const util = require('./../utilities/utilities');

module.exports = {
    index: (req, res) => {
        Genre.find({}).sort('name').then(categories => {
            let populateQuery = [
                {path: 'added_by',   select: 'fullName'},
                {path: 'categories', select: 'name'},
                {path: 'tags',     select: 'name'}
            ];
            Movie.find({},'poster_url youtube_trailers').populate(populateQuery).then(movies => {
                //console.log(movies);
                let firstMovie = [];
                let sliderMovies = [];
                let sliderButtons = [];
                //console.log(movies);
                //util.getFieldToArr(movies,'poster_url);
                let firstMovieIndex = util.randomIntFromInterval(0,movies.length -1);
                firstMovie = movies[firstMovieIndex] ;
                //console.log(firstMovie);
                delete  movies[firstMovieIndex];
                //console.log(movies);

                if(movies.length < config.homeConfig.scrollerImages -1 ){
                    sliderMovies = movies;
                    for (let i = 1; i < sliderMovies.length + 1; i++) {
                        sliderButtons.push(i);
                    }
                }else {
                    for (let i = 0; i < config.homeConfig.scrollerImages -1; i++) {
                        let movieIndex = util.randomIntFromInterval(0,movies.length -1);
                        sliderMovies = movies[movieIndex];
                        delete movies[movieIndex];
                    }
                    for (let i = 1; i < sliderMovies.length + 1; i++) {
                        sliderButtons.push(i);
                    }
                }
                //console.log(sliderMovies);

                res.render('home/index', {
                    subTitle: 'Home',
                    categories:  categories,
                    firstMovie:  firstMovie,
                    sliderMovies: sliderMovies,
                    sliderButtons: sliderButtons
                });
            })
        })
    },
    contact:(req, res) =>{
        res.render('home/contact');
    },
    about:(req, res) =>{
        let developersInfo = [];
        developersInfo.push({name:'Theodora',   picture:'/images/ted.jpg',  jobTitle:'Developer'});
        developersInfo.push({name:'Boris',      picture:'/images/boris.jpg',jobTitle:'Developer'});
        developersInfo.push({name:'Emo',        picture:'/images/emo.jpg',  jobTitle:'Developer'});
        developersInfo.push({name:'Petio',      picture:'/images/Petio.jpg',jobTitle:'Developer'});
        developersInfo.push({name:'Venci',      picture:'/images/venci.jpg',jobTitle:'Developer'});
        developersInfo.push({name:'Marto',      picture:'/images/marti.jpg',jobTitle:'Developer'});
        res.render('home/about',{
            developersInfo:developersInfo
        });
    },

    listGenreMovies: (req, res) => {
        let genreId = req.params.id;
        let currentPage = parseInt(req.params.page);
        if(isNaN(currentPage)){
            currentPage = 1;
        }

        Genre.find({}).sort('name').then(genre => {
            Genre.findById(genreId).then(genres => {
                // this will is slow quarry
                Movie.paginate({genres:genreId},{page: currentPage, limit: config.categoriesConfig.postLimit}).then(pagesInfo => {
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
                        res.render('home/movies', {
                            subTitle: 'List of all movie in ' + genres.name + ' category!', // subTitle
                            movies: pagesInfo.docs, // the movie..
                            categoryId: genreId, // category id..
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

                })

            });
        });
    }
};