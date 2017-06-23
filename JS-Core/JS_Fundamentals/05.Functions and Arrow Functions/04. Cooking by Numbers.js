function coock(array) {
  let number = Number(array[0]);

  let numbersString = '';
  for (let i = 1; i < array.length; i++) {
    number = cook(number, array[i]);
    numbersString += number + '\n';
  }
  console.log(numbersString)
  function cook(number, operation) {
    switch (operation) {
      case 'chop':
        return  number / 2;
      case 'spice':
        return ++number;
      case 'bake':
        return  number * 3;
      case 'fillet':
        return  number * 0.80;
      case 'dice':
        return  Math.sqrt(number);
      default:
        break;
    }
  }
}

coock([9, 'dice', 'spice', 'chop', 'bake', 'fillet']);

