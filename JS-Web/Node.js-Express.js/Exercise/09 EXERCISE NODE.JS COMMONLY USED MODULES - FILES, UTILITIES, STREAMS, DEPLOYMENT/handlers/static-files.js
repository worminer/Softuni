const fs = require('fs');
const path = require('path');
const zlib = require('zlib');

module.exports = (req, res) => {
  if (req.path.startsWith('/content/') && req.method === 'GET') {
    if (!req.path.toLowerCase().endsWith('.jpg') && !req.path.endsWith('.png') &&
      !req.path.endsWith('.js') && !req.path.endsWith('.css')) {
      res.writeHead(400);
      res.write('Bad request!');
      return res.end()
    }
    res.writeHead(200, {
      'content-encoding': 'gzip',
      'Content-Disposition': 'attachment'
    });
    fs.createReadStream(path.normalize(path.join(__dirname, '..', req.path))).pipe(zlib.createGzip()).pipe(res)
  } else {
    return true
  }
};
