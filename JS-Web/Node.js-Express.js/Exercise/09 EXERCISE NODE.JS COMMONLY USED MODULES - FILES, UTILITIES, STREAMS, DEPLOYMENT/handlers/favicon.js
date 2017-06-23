const fs = require('fs');
const path = require('path');

module.exports = (req, res) => {
  if (req.path === '/favicon.ico' && req.method === 'GET') {
    fs.readFile(path.normalize(path.join(__dirname, '..', 'content', req.path)), (err, data) => {
      if (err) {
        console.log('err', err);
        res.writeHead(404);
        res.write('NOT FOUND');
        return res.end()
      }
      res.writeHead(200);
      res.write(data);
      return res.end()
    })
  } else {
    return true
  }
};
