const fs = require('fs');
const path = require('path');
const db = require('../config/database');

module.exports = (req, res) => {
  if (req.path.startsWith('/details/') && req.method === 'GET') {
    let imgIndex = req.path.split('/')[2] || 0;
    fs.readFile(path.normalize(path.join(__dirname, '..', 'views', 'details.html')), (err, data) => {
      if (err) {
        console.log(err);
        res.writeHead(404);
        res.write('ERROR');
        return res.end()
      }
      res.writeHead(200, {
        'Content-Type': 'text/html'
      });
      let picture = db.getImageItem(imgIndex);
      if (picture) {
        let content = `
          <h1>${picture.name}</h1>
          <img src="${picture.imageUrl}">`;
        let html = data.toString().replace('{{ content }}', content);
        res.write(html);
        return res.end()
      } else {
        let html = data.toString().replace('{{ content }}', 'No such picture.');
        res.write(html);
        return res.end()
      }
    })
  } else {
    return true
  }
};
