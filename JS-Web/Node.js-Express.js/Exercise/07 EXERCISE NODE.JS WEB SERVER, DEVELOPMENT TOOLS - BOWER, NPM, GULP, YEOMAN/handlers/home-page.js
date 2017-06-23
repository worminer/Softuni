const fs = require('fs');
const path = require('path');
module.exports = (req, res) => {
  if (req.path === '/' && req.method === 'GET') {
    fs.readFile(path.normalize(path.join(__dirname, '..', 'views', 'index.html')), (err, data) => {
      if (err) {
        console.log(err);
        res.writeHead(404);
        res.write('ERROR');
        return res.end()
      }
      res.writeHead(200, {
        'Content-Type': 'text/html'
      });
      res.write(data);
      return res.end()
    })
  } else {
    return true
  }
};
