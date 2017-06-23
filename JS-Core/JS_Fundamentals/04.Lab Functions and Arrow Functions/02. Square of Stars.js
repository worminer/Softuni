function drow(n) {
  n = Number(n);
  let result = '';
  for (let i = 0; i < n; i++) {
    result += '* '.repeat(n) + '\n';
  }
  console.log(result);
}
drow(5);