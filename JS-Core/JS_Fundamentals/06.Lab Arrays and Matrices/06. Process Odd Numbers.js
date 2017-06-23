function solve(array) {
  array = array
      .map(Number)
      .filter((x, i) => i % 2 !== 0)
      .map(x => x = x * 2)
      .reverse();

  console.log(array.join(' '));
}

solve(['3', '0', '10', '4', '7', '3']);