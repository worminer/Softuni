const fs = require('fs');
const path = require('path');
const multiparty = require('multiparty');
const db = require('../config/database');

module.exports = (req, res) => {
  if (req.path === '/add' && req.method === 'POST') {
    let form = new multiparty.Form();
    form.parse(req);
    let obj = {};

    form.on('error', (err) => {
      res.end('Error!');
      console.log(err)
    });

    form.on('part', (part) => {
      if (!part.filename) {
        let field = '';
        part.on('data', (data) => {
          field += data
        });

        part.on('end', () => {
          obj[part.name] = field
        });
        part.resume()
      }
      part.on('error', (err) => {
        res.end('Error!');
        console.log(err)
      })
    });

    form.on('close', function () {
      if (!obj.name || !obj.imageUrl) {
        res.end('Please fill in both fields.')
      } else {
        db.addNewImage(obj);
        res.writeHead(302, {
          Location: '/'
        });
        res.end()
      }
    })
  } else if (req.path === '/add' && req.method === 'GET') {
    fs.readFile(path.normalize(path.join(__dirname, '..', 'views', 'add.html')), (err, data) => {
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
