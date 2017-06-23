const url = require('url');
const database = require('../config/database');
const fs = require('fs');
const path = require('path');
const qs = require('querystring');
const multiparty = require('multiparty');
const shortid = require('shortid');

module.exports = (req, res) => {
  req.pathname = req.pathname || url.parse(req.url).pathname;

  if (req.pathname === '/products/add' && req.method === 'GET') {
    let filePath = path.normalize(path.join(__dirname, '../views/products/add.html'));
    fs.readFile(filePath, (err, data) => {
      if (err) {
        console.log(err);
        res.writeHead(404, {
          'Content-Type': 'text/plain'
        });
        res.write('404 not found!');
        return res.end()
      }
      res.writeHead(200, {
        'Content-Type': 'text/html'
      });
      res.write(data);
      res.end()
    })
  } else if (req.pathname === '/products/add' && req.method === 'POST') {
    let form = new multiparty.Form();
    form.parse(req);

    let product = {};
    form.on('error', (error) => {
      console.log(error)
    });
    form.on('part', (part) => {
      if (part.filename) {
        let dataString = '';

        part.setEncoding('binary');
        part.on('data', (data) => {
          dataString += data
        });

        part.on('end', () => {
          let fileName = shortid.generate();
          let fileExt = part.filename.slice(part.filename.lastIndexOf('.'));
          let filePath = path.normalize(path.join(__dirname, '..', 'content', 'images', `${fileName}${fileExt}`));
          product.image = path.normalize(path.join('content', 'images', `${fileName}${fileExt}`));
          fs.writeFile(`${filePath}`, dataString, { encoding: 'ascii' }, (err) => {
            if (err) {
              console.log(err);
              return false
            }
          })
        })
      } else {
        part.setEncoding('utf-8');
        let field = '';
        part.on('data', (data) => {
          field += data
        });

        part.on('end', () => {
          product[part.name] = field
        })
      }
    });

    form.on('close', () => {
      database.products.add(product);
      res.writeHead(302, {
        Location: '/'
      });
      res.end()
    })
  } else {
    return true
  }
};