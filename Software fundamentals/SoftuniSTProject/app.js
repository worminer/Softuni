const express = require('express');
const config = require('./config/config');
const app = express();

//let env = 'development'; // deprecated -> moved to config.env
// setting variables for the whole site
app.locals.site = {
    titleOptions: config.titleOptions,
    config      : config,                       // passing all configurations
};
require('./config/handlebars')();
require('./config/database')(config);
require('./config/express')(app, config);
require('./config/passport')();
require('./config/routes')(app);


module.exports = app;