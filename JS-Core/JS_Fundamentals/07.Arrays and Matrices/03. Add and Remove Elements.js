function addRemove(arr) {
  let result = [];
  let counter = 1;
  for (let key in arr) {
    if (arr[key] === 'add') {
      result.push(counter);
    } else if (arr[key] === 'remove') {
      result.pop();
    }
    counter++;
  }
  if (result.length === 0) {
    console.log('Empty');
  }else {
    result.forEach(r => console.log(r.toString()));
  }
}

addRemove(['add','add','remove','add','add',]);