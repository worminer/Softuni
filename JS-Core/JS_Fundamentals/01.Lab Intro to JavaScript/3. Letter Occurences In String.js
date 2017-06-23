function countLetterInStr(str, letterToFind) {
  let counter = 0;
  for (let letter of str) {
    if (letter === letterToFind) {
      counter++;
    }
  }
  console.log(counter);
}