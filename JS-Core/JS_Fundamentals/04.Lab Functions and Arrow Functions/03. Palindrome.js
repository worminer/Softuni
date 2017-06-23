function palindrome(word) {
  return word === word.split('').reverse().join('');
}