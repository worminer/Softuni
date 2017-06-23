function sortCars(dataArr) {
  let makes = new Map;
  for (let row of dataArr) {
    let [make, model, quantity] = row.split(/\s\|\s/g);
    if (!makes.has(make)) {
      makes.set(make, new Map);
    }
    let currentMake = makes.get(make);
    if (!currentMake.has(model)) {
      currentMake.set(model,0)
    }
    currentMake.set(model,currentMake.get(model) + Number(quantity));
  }
  for (let [make,items] of makes) {
    console.log(make);
    for (let [item, quantity] of items) {
      console.log(`###${item} -> ${quantity}`)
    }
  }
}

sortCars([
  "Audi | Q7 | 1000",
  "Audi | Q6 | 100",
  "BMW | X5 | 1000",
  "BMW | X6 | 100",
  "Citroen | C4 | 123",
  "Volga | GAZ-24 | 1000000",
  "Lada | Niva | 1000000",
  "Lada | Jigula | 1000000",
  "Citroen | C4 | 22",
  "Citroen | C5 | 10",

]);