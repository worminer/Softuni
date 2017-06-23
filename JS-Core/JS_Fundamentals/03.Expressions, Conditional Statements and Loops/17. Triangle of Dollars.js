function triangleOfDollars(n) {
  let triangle = '';
  for (let column = 1; column <= n; column++) {
    triangle += '$'.repeat(column) + '\n';
  }
  console.log(triangle);
}
triangleOfDollars(10)