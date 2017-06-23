function foodType(item) {
  switch (item) {
     // fruits
    case 'banana':
    case 'apple':
    case 'kiwi':
    case 'cherry':
    case 'lemon':
    case 'grapes':
    case 'peach':
      console.log('fruit');
      break;
      // vegetables
    case 'tomato':
    case 'cucumber':
    case 'pepper':
    case 'onion':
    case 'parsley':
    case 'garlic':
      console.log('vegetable');
      break;
      // unknown type
    default:
      console.log('unknown');
  }
}