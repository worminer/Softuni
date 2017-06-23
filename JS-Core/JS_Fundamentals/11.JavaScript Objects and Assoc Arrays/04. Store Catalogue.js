function storageCatalog(itemArr) {
  let catalog = new Map;
  for (let item of itemArr) {
    let [product, price] = item.split(/\s:\s/g);
    if (!catalog.has(product.charAt(0))) {
      catalog.set(product.charAt(0), [])
    }
    catalog.get(product.charAt(0)).push({product:product,price:price});
    //catalog.set(product.charAt(0),test)
  }

  for (let [set,items] of [...catalog].sort()) {
    console.log(set);
    items.sort(function(a, b){
      if(a.product.toLowerCase() < b.product.toLowerCase()) return -1;
      if(a.product.toLowerCase() > b.product.toLowerCase()) return 1;
      return 0;
    });
    for (let item of items) {
      console.log(`  ${item.product}: ${item.price}`)
    }
    
  }

}
storageCatalog(
  [
    'Appricot : 20.4',
    'Fridge : 1500',
    'TV : 1499',
    'Deodorant : 10',
    'Boiler : 300',
    'Apple : 1.25',
    'Anti-Bug Spray : 15',
    'T-Shirt : 10',
  ]
);

storageCatalog([
  "Banana : 2",
  "Rubic's Cube : 5",
  "Raspberry P : 4999",
  "Rolex : 100000",
  "Rollon : 10",
  "Rali Car : 2000000",
  "Pesho : 0.000001",
  "Barrel : 10",
]);