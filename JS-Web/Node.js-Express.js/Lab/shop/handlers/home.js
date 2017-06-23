const url = require('url');
const fs = require('fs');
const path = require('path');
const database = require('../config/database');
const qs = require('querystring');

module.exports = (req, res) => {
  req.pathname = req.pathname || url.parse(req.url).pathname;
  if (req.pathname === '/' && req.method === 'GET') {
    let filePath = path.normalize(path.join(__dirname, '../views/home/index.html'));
    fs.readFile(filePath, (err, data) => {
      if (err) {
        console.log(err);
        res.writeHead(404, {
          'Content-Type' : 'text-plain'
        });
        res.write('404 not found!');
        res.end();
        return
      }
      res.writeHead(200, {
        'Content-Type' : 'text-plain'
      });
      let queryData = qs.parse(url.parse(req.url).query);

      let products = {};
      let content = '';
      if (queryData['query'] !== undefined) {

        let product = database.products.findByName(queryData['query'])
        if (product === null) {
          content = "No such product in DB!";
        } else {
          content += ` 
            <div class="product-card">
                <img src="${product.image}" alt="product_img" class="product-img">
                <h2>${product.name}</h2>
                <p>${product.description}</p>
            </div>`;
        }
      } else {
        products = database.products.getAllImages();
        for (let product of products) {
          content += ` 
            <div class="product-card">
                <img src="${product.image}" alt="product_img" class="product-img">
                <h2>${product.name}</h2>
                <p>${product.description}</p>
            </div>`;
        }
      }




      let html = data.toString().replace('{content}', content);
      res.write(html);
      res.end();
    })
  } else {
    return true;
  }
};


