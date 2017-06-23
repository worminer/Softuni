const fs = require('fs');
const path = require('path');
const db = require('../config/database');

module.exports = (req, res) => {
  if (req.path === '/list' && req.method === 'GET') {
    fs.readFile(path.normalize(path.join(__dirname, '..', 'views', 'list.html')), (err, data) => {
      if (err) {
        console.log(err);
        res.writeHead(404);
        res.write('ERROR');
        return res.end()
      }
      res.writeHead(200, {
        'Content-Type': 'text/html'
      });
      let content = '<ol start="0">';
      let pictures = db.getAllImages();
      for (let [index, picture] of pictures.entries()) {
        content += `<li><a href="details/${index}"><h3>${picture.name}</h3></a></li>`
      }
      content += '</ol>';
      let html = data.toString().replace('{{ content }}', content);
      res.write(html);
      return res.end()
    })
  } else {
    return true
  }
};