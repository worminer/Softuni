function solve(array) {
  let result = array.filter((x, i) => i % 2 == 0).join(' ');
  console.log(result);
}