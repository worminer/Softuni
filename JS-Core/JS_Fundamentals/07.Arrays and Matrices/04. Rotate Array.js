function rotateArr(arr) {
  let rotations = arr.pop();
  for (let i = 0; i < rotations; i++) {
    arr.unshift(arr.pop());
  }
  console.log(arr.join(' '));
}

rotateArr(['Banana', 'Orange', 'Coconut', 'Apple', 15]);