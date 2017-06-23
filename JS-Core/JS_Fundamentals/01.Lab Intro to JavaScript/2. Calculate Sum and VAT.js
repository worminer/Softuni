function sumVat(arr) {
  let sum = 0;
  for (let number of arr) {
    sum += number;
  }
  console.log(sum);
  console.log(sum * 0.2);
  console.log(sum + (sum * 0.2))
}