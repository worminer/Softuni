'use strict';
function formFiller(arr) {
  let result = ''
  for(let line of arr[3]) {
    result += line
        .replace(/<![A-Za-z]+!>/g, arr[0])
        .replace(/<@[A-Za-z]+@>/g, arr[1])
        .replace(/<\+[A-Za-z]+\+>/g, arr[2]) + '\n';
  }
  console.log(result);
}

console.log(formFiller([
  'Pesho',
  'pesho@softuni.bg',
  '90-60-90',
  ['Hello, <!username!>!',
    'Welcome to your Personal profile.',
    'Here you can modify your profile freely.',
    'Your current username is: <!fdsfs!>. Would you like to change that? (Y/N)',
    'Your current email is: <@DasEmail@>. Would you like to change that? (Y/N)',
    'Your current phone number is: <+number+>. Would you like to change that? (Y/N)']

]));;