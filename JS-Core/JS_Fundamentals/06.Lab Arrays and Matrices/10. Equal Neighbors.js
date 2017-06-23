function neighbors(matrix) {
  let count = 0;
  for (let row = 0; row < matrix.length - 1; row++) {
    for (let col = 0; col < matrix[row].length; col++) {
      let currentElement = matrix[row][col];

      if (currentElement === matrix[row + 1][col])
        count++;
    }
  }

  for (let row = 0; row < matrix.length; row++) {
    for (let col = 0; col < matrix[row].length - 1; col++) {
      let currentElement = matrix[row][col];

      if (currentElement === matrix[row][col + 1])
        count++;
    }
  }

  console.log(count);
}

neighbors([
    ['test', 'yes', 'yo', 'ho'],
    ['well', 'done', 'yo', '6'],
    ['not', 'done', 'yet', '5']
  ]
);