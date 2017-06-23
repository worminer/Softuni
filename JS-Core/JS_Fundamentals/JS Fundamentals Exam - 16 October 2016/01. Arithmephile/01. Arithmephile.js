function solve(numbersArr) {
  numbersArr = numbersArr.map(Number);
  let biggestProduct = -9007199254740991;
  for (let i = 0; i < numbersArr.length; i++) {
    let number = numbersArr[i];
    if (number >=0 && number < 10) {
      let products = [];
      if(typeof numbersArr[i+1] !== 'undefined') {
        for (let j = i+1; j <= Math.min(numbersArr.length, number + i) ; j++) {
          products.push(numbersArr[j]);
        }
        let product = 0;
        if (products.length === 0) {
          continue;
        }
        if (products.length === 1) {
          product = products[0];
        } else {
          product = products.reduce((a, b) => a * b);
        }
        if (biggestProduct < product) {
          biggestProduct = product;
        }


      }
    }
  }
  console.log(biggestProduct);
}

solve( ['10', '20', '2', '30', '44','110', '3', '56', '20', '24','32']);

solve([
  '9',
  '5652',
  '5652',
  '9190',
  '4172',
  '494',
  '536',
  '9510',
  '1584',
  '0',
  '1',
  '10',
  '6',
  '0',
  '675',
  '8913',
  '1891',
  '4298',
  '269',
  '3754',
  '6459',
]);

solve([
  '18',
  '42',
  '19',
  '36',
  '1',
  '-297',
  '38',
  '100',
  '9',
  '-249',
  '-170',
  '-18',
  '-208',
  '-11',
  '-87',
  '-90',
  '-286',
  '-27',
])