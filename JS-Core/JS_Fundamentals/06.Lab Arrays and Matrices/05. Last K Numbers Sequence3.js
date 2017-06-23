function solve(n,k) {
  [n, k] = [n, k].map(Number);
  let result = [1];

  for (let i = 1; i < n; i++) {
    let sum = 0;
    for (let j = i - 1; j >= Math.max(i - k,0); j--) {
      sum += result[j];
    }
    result[i] = sum;
  }

  console.log(result.join(' '));
}

solve(['8', '2']);