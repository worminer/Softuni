function concatAndReverse(arr) {
  return Array.from(arr.join('')).reverse().join('');
}

console.log(concatAndReverse(['I', 'am', 'student']));;