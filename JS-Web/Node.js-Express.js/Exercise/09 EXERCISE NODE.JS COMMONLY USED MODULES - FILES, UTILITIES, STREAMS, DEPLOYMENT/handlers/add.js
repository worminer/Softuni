const fs = require('fs');
const path = require('path');
const multiparty = require('multiparty');
const database = require('../config/database');
const shortid = require('shortid');
const mkdirp = require('mkdirp');
const zlib = require('zlib');

function getFileLocation () {
  let date = new Date();
  const day = date.getDate();
  const month = date.getMonth() + 1;
  const year = date.getFullYear();
  return [year, month, day].map(String)
}

module.exports = (req, res) => {
  if (req.path === '/add' && req.method === 'POST') {
    let form = new multiparty.Form();
    form.parse(req);

    let product = {};
    form.on('error', (error) => {
      console.log(error)
    });
    form.on('part', (part) => {
      if (part.filename) {
        let fileName = shortid.generate();
        let fileExt = part.filename.slice(part.filename.lastIndexOf('.'));

        let timeBasedDir = getFileLocation();
        let dirStructure = path.normalize(path.join(__dirname, '..', 'content', 'images', ...timeBasedDir));

        if (!fs.existsSync(dirStructure)) {
          mkdirp.sync(dirStructure)
        }
        let filePath = path.normalize(path.join(__dirname, '..', 'content', 'images', ...timeBasedDir, `${fileName}${fileExt}`));
        product.image = path.normalize(path.join('content', 'images', ...timeBasedDir, `${fileName}${fileExt}`));
        let ws = fs.createWriteStream(filePath, { encoding: 'binary' });
        part.setEncoding('binary');
        part.pipe(ws)
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
  } else if (req.path === '/add' && req.method === 'GET') {
    res.writeHead(200, {
      'content-encoding': 'gzip',
      'Content-Type': 'text/html'
    });
    fs.createReadStream(path.normalize(path.join(__dirname, '..', 'views', 'add.html'))).pipe(zlib.createGzip()).pipe(res)
  } else {
    return true
  }
};
