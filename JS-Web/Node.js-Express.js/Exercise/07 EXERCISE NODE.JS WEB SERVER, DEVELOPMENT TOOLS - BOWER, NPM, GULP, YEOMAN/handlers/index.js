const faviconHandler = require('./favicon');
const staticFilesHandler = require('./static-files');
const homePageHandler = require('./home-page');
const addHandler = require('./add');
const listHander = require('./list');
const detailsHandler = require('./details');
const headerHandler = require('./header');

module.exports = [
  headerHandler,
  faviconHandler,
  staticFilesHandler,
  homePageHandler,
  addHandler,
  listHander,
  detailsHandler
];
