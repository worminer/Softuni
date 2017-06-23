const path = require('path');

module.exports.env = "development"; // setting the environment

if(this.env == "development") {
    module.exports =
    {
        rootFolder: path.normalize(path.join(__dirname, '/../')), // path to root folder
        connectionString: 'mongodb://localhost:27017/FilmCatalog', // db string
        seedCategories: false, // if enabled will seed categories in db
        titleOptions: {
            siteTitle: "BEMP TV MovieHub", // title to be shown in all pages
            LongTitles: true, // if enabled .. pages will show subTitle as "Title - SubTitle"
            titleSeparator: ' - '
        },
        youtubeOptions:{
            apiKey: 'AIzaSyBfpJz2T3f1SVEoX2HgtcAEaN1Vj4XJ-RA',
            resultsCount: 2,
        },
        globalOptions:{
            plotCharLimit: 300, // limits the chars for the plot for the movie previews
            showRandomTrailer: true // if enabled will display random trailer at the movie previews
        },
        genreMenu: { // Global options for the the left side category menu
            hideEmptyGenres: true //if enabled .. categories that have 0 items will not be drown
        },

        homeConfig:{ // config for homeController / index
            scrollerImages: 10 // limits the posts in the homepage
        },
        categoriesConfig:{ // config for homeController / listGenreMovies
            postLimit: 5, // limits the posts in the listGenreMovies
        },
        searchConfig:{ // config for homeController / listGenreMovies
            postLimit: 5, // limits the posts in the listGenreMovies
        }
        ,
        tagConfig:{ // config for tagController / lisMoviesByTag
            postLimit: 5, // limits the posts in the lisMoviesByTag
        }

    }
}else if(this.env == "production") {
    module.exports =
        {
        }
}






