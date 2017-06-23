const config = require('./../config/config');
const mongoose = require('mongoose');
const Movie = require('mongoose').model('Movie');
const Tag = require('mongoose').model('Tag');
const User = mongoose.model('User');
const Category = mongoose.model('Genre');

module.exports = {
    lisMoviesByTag: (req, res) => {
        let name = req.params.name;

        let currentPage = parseInt(req.params.page);
        if(isNaN(currentPage)){
            currentPage = 1;
        }
        Category.find({}).sort('name').then(categories => {
            Tag.findOne({name: name}).then(tag => {
                let tagMovies = tag.movies;
                Movie.paginate({_id: { $in:tagMovies}},{page: currentPage, limit: config.categoriesConfig.postLimit}).then(pagesInfo => {
                    let populateQuery = [
                        {path:'author', select: 'fullName'},
                        {path: 'category', select: 'name'},
                        {path: 'tags', select: 'name'}
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

                        let pageArr = []

                        for (let i = 1; i <= pagesInfo.pages; i++) {
                            pageArr.push(i)
                        }

                        res.render('tag/details', {
                            subTitle: 'List of all movie with tag ' + tag.name + '..', // subTitle
                            tag: tag,       // current tag
                            movies: pagesInfo.docs, // all the movie for this tag..
                            categories: categories, // all the categories for the left menu
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
            })
        });

    }
};