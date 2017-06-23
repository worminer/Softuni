function printNth(arr) {
let nth = arr.pop();
  arr.forEach((r,i) => i % nth === 0 ? console.log(r):'')
}

printNth([5, 20, 31, 4, 20, 2,]);