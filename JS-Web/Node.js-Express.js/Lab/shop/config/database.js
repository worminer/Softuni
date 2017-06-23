const fs = require('fs');
const path = require('path');
const dbPath = path.join(__dirname, '/database.json');

const getProducts = () => {
  if (!fs.existsSync(dbPath)) {
    fs.writeFileSync(dbPath, '[]');
    return []
  }
  let json = fs.readFileSync(dbPath).toString() || '[]';
  let products = JSON.parse(json);
  return products
};

const saveProducts = (products) => {
  let json = JSON.stringify(products);
  fs.writeFileSync(dbPath, json)
};

module.exports.products = {
  getAll: getProducts,
  add: (product) => {
    const products = getProducts();
    product.id = products.length + 1;
    products.push(product);
    saveProducts(products)
  },
  findByName: (name) => {
    return getProducts().filter(p => p.name.toLowerCase().includes(name))
  }
};