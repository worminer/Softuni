function solve(array) {
  let result = [];
  for(let item of array) {
    if (item < 0)
      result.unshift(item);
    else
      result.push(item);
  }

  result.forEach(x => console.log(x));
}

solve(['7', '-2', '8', '9']);