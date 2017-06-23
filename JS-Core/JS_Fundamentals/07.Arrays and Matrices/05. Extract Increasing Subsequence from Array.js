function subset(arr) {
let currentBiggestNum = Number.NEGATIVE_INFINITY;
let result = [];
  for (let num of arr) {
    if (num >= currentBiggestNum) {
      currentBiggestNum = num;
      console.log(num);
    }
  }
}
subset([1, 3, 8, 4, 10, 12, 3, 2, 24]);