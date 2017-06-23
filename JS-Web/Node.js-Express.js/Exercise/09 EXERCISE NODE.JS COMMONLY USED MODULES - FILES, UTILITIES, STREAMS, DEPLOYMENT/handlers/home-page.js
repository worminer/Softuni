const fs = require('fs');
const path = require('path');
const zlib = require('zlib');

module.exports = (req, res) => {
  if (req.path === '/' && req.method === 'GET') {
    res.writeHead(200, {
      'content-encoding': 'gzip',
      'Content-Type': 'text/html'
    });
    fs.createReadStream(path.normalize(path.join(__dirname, '..', 'views', 'index.html'))).pipe(zlib.createGzip()).pipe(res)
  } else {
    return true
  }
};
