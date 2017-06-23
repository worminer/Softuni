function wordsToUpper(str) {
  let result = str.toUpperCase();
  result = result.split(/\W+/).filter(w => w !== '').join(', ');
  console.log(result);
}