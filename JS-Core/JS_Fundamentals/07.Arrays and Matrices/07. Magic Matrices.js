function magicMatrix(arr) {
  let sum = null;
  let columnSumArr = [0,0,0];
  for (let row = 0; row < arr.length; row++) {
    let currentRowSum = 0;
    for (let element = 0; element < arr.length; element++) {
      currentRowSum += arr[row][element];
      columnSumArr[element] += arr[row][element];
    }
    if (sum === null) {
      sum = currentRowSum;
    } else {
      if (sum !== currentRowSum) {
        return false;
      }
    }
  }

  columnSumArr.forEach(e => e !== sum ? false :'');
  return true;
}

console.log(magicMatrix([
      [4, 5, 6],
      [6, 5, 4],
      [5, 5, 5]
    ]
));;