function countOccurrences(search, text) {
  let count = 0;
  let index = 0;
  while(text.indexOf(search, index) > -1) {
    count++;
    index = text.indexOf(search, index) + 1;
  }

  console.log(count);
}