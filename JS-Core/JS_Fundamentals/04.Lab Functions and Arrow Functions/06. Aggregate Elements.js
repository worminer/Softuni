function agregate(arr) {
  //sum
  let sum = 0;
  let inverse = 0;
  let concat = '';
  for (let number of arr) {
    sum += number;
    concat += number;
    inverse += 1/number;
  }



  console.log(sum);
  console.log(inverse);
  console.log(concat);
}
agregate([1, 2, 3]);
agregate([2, 4, 8, 16]);