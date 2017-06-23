const fs = require('fs');
const path = require('path');
const db = require('../config/database.js');

module.exports = (req, res) => {
  let statusHeader = req.headers['statusheader'] || req.headers['StatusHeader'];
  if ((req.path === '/count' && req.method === 'GET') || statusHeader === 'Full') {
    fs.readFile(path.normalize(path.join(__dirname, '..', 'views', 'header.html')), (err, data) => {
      if (err) {
        console.log(err);
        res.writeHead(404);
        res.write('ERROR');
        return res.end()
      }
      res.writeHead(200, {
        'Content-Type': 'text/html'
      });
      let content = '';
      let pictures = db.products.getAll().length;
      content += `There are ${pictures} pictures.`;
      let html = data.toString().replace('{{content}}', content);
      res.write(html);
      return res.end()
    })
  } else {
    return true
  }
};
