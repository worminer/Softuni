function solve(arr) {
  let k = Number(arr[0]);
  let firstNumArr = arr.slice(1,k + 1);
  let lastNumArr = arr.slice(arr.length  - k,arr.length);
  console.log(firstNumArr);
  console.log(lastNumArr);
}

solve(['3', '6', '7', '8', '9']);