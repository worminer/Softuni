const homeHandler = require('./home');
const staticFilesHandler = require('./static-files');
const productsHandler = require('./products');

module.exports = [
  homeHandler,
  staticFilesHandler,
  productsHandler
];
