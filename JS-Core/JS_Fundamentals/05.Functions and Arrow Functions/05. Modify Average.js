'use strict';

function modifyAvg(number) {
  let strNumber = number.toString();
  let average = findAverage(strNumber);

  while (average <= 5) {
    strNumber = strNumber + 9;
    average = findAverage(strNumber);
  }

  function findAverage(strNumber) {
    let sum = 0;
    for (let i = 0; i < strNumber.length; i++) {
      sum += Number(strNumber[i]);
    }

    return sum / strNumber.length;
  }
  console.log(strNumber);
}

modifyAvg(101);
modifyAvg(5835);