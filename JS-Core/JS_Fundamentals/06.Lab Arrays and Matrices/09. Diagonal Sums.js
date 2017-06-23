function solve(matrix) {
  let firstSum = 0;
  let secondSum = 0;

  for (let i = 0; i < matrix.length; i++) {
    firstSum += matrix[i][i];
    secondSum += matrix[i][matrix.length - 1 - i];
  }

  console.log(`${firstSum} ${secondSum}`);
}

solve([[20, 40], [10,60]]);