const fs = require('fs');
const path = require('path');

module.exports = (req, res) => {
  if (req.path.startsWith('/content/') && req.method === 'GET') {
    if (!req.path.endsWith('.jpg') &&
        !req.path.endsWith('.png') &&
        !req.path.endsWith('.js')  && 
        !req.path.endsWith('.css'))
    {
      res.writeHead(400);
      res.write('Bad request!');
      return res.end()
    }
    fs.readFile(path.normalize(path.join(__dirname, '..', req.path)), (err, data) => {
      if (err) {
        res.writeHead(404);
        res.write('ERROR');
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
