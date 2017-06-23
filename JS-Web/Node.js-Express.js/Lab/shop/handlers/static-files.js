const url = require('url');
const fs = require('fs');
const path = require('path');

// returns the content type and also will be used to serve only content of those types
// in other words.. returns the content type or false
function getContentType(url) {
  // text based content
  //.css
  if (url.endsWith('.css'))
  {
    return 'text/css';
  }
  //.html
  if (url.endsWith('.html')) {
    return 'text/html';
  }

  // image based content
  if (url.endsWith('.ico')) {
    return 'image/x-icon';
  }
  if (url.endsWith('.jpg')) {
    return 'image/jpeg';
  }
  if (url.endsWith('.png')) {
    return 'image/png';
  }
  if (url.endsWith('.gif')) {
    return 'image/gif';
  }

  // if it gets to here .. file is not allowed so return false
  return false;
}

module.exports = (req, res) => {
  req.pathname = req.pathname || url.parse(req.url).pathname;

  if (req.pathname.startsWith('/content/') && req.method === 'GET') {
    let  filePath = path.normalize(
        path.join(__dirname, `..${req.pathname}`)
    );

    if (getContentType(req.pathname)) {
      fs.readFile(filePath, (err, data) => {
        if (err) {
          console.log(err);
          res.writeHead(404, {
            'Content-Type' : 'text-plain'
          });
          res.write('Resource not found');
          res.end();
          return
        }
        res.writeHead(200, {
          'Content-Type' : getContentType(req.pathname)
        });
        res.write(data);
        res.end();
      })
    } else {
      res.writeHead(404, {
        'Content-Type': 'text-plain'
      });
      res.write('This content type is not allowed by the server');
      res.end();
    }

  } else {
    return true;
  }

}