function solve(arr) {
  let maxNumber = Number.NEGATIVE_INFINITY;
  arr.forEach(r => r.forEach(e => maxNumber = Math.max(e,maxNumber)))
  console.log(maxNumber);
}

solve([[20, 50, 10], [8, 33, 145]]);
solve([[3, 5, 7, 12],[-1, 4, 33, 2],[8, 3, 0, 4]]);

