const Handlebars = require("hbs");
const categoriesMenu = require('./../views/partials/categories_menu.hbs');
const moviesPreview = require('./../views/partials/movies_preview.hbs');
const imdbAddMovieForm = require('./../views/partials/imdb_add_movie_form.hbs');
const crudMovieForm = require('./../views/partials/crud_movie_form.hbs');
const util = require('./../utilities/utilities');


module.exports = () => {
    //Partials
    Handlebars.registerPartial('categoriesMenu', categoriesMenu); // categories side menu
    Handlebars.registerPartial('moviesPreview', moviesPreview); // multiple movie previews
    Handlebars.registerPartial('imdbAddMovieForm', imdbAddMovieForm); // imdb add movie form
    Handlebars.registerPartial('crudMovieForm', crudMovieForm); // crud add movie form

    //Helpers
    //Create a custom function helper to check the status.
    Handlebars.registerHelper('equal', function(lvalue, rvalue, options) {
        if (arguments.length < 3)
            throw new Error("Handlebars Helper equal needs 2 parameters");
        if( lvalue!=rvalue ) {
            return options.inverse(this);
        } else {
            return options.fn(this);
        }
    });

    Handlebars.registerHelper('multiply', function(value, multiplayer, options) {
        if (arguments.length < 3){
            throw new Error("Handlebars Helper multiply needs 2 parameters");
        }

        return options.fn(value * multiplayer);
    });

    Handlebars.registerHelper('firstOrRandom', function(array ,randomize) {
        let result;
        if(typeof array === 'undefined'){
            array = [];
            console.log("handlebar helper: firstOrRandom -> array is undefined at handlebars helper!");
        }
        if(typeof randomize === 'undefined'){
            randomize = false;
        }
        if(randomize){
            let randomTrailerId = util.randomIntFromInterval(0,array.length-1);
            result = array[randomTrailerId];
        }else {
            result = array[0];
        }
        return result;
    });

    Handlebars.registerHelper('dotdotdot', function(str ,len) {
        if(typeof str === 'undefined'){
            str = '';
            console.log("handlebar helper: dotdotdot -> str is undefined at handlebars helper!");
        }
        if(typeof len === 'undefined'){
          len = 10;
          console.log("handlebar helper: dotdotdot -> len is undefined at handlebars helper!");
        }
        if(len <=10){
          len = 10
        }
        //console.log("handlebar helper: dotdotdot -> len is " + len);
        if (str.length > len)
            return str.substring(0,len) + '...';
        return str;
    });

    // compare for handlebars
    // Usage!
    // {{#compare unicorns ponies operator="<"}}
    // I knew it, unicorns are just low-quality ponies!
    // {{/compare}}
    Handlebars.registerHelper('compare', function(lvalue, rvalue, options) {

        if (arguments.length < 3)
            throw new Error("Handlerbars Helper 'compare' needs 2 parameters");

        var operator = options.hash.operator || "==";

        var operators = {
            '==':       function(l,r) { return l == r; },
            '===':      function(l,r) { return l === r; },
            '!=':       function(l,r) { return l != r; },
            '<':        function(l,r) { return l < r; },
            '>':        function(l,r) { return l > r; },
            '<=':       function(l,r) { return l <= r; },
            '>=':       function(l,r) { return l >= r; },
            'typeof':   function(l,r) { return typeof l == r; }
        }

        if (!operators[operator])
            throw new Error("Handlerbars Helper 'compare' doesn't know the operator "+operator);

        var result = operators[operator](lvalue,rvalue);

        if( result ) {
            return options.fn(this);
        } else {
            return options.inverse(this);
        }

    });

};