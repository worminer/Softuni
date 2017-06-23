function insideVolume(array) {
  array = array.map(Number);
  for (let i = 0; i < array.length; i+=3) {
    let x = array[i], y = array[i + 1], z = array[i + 2];
    if (isInside(x,y,z))
      console.log('inside');
    else
      console.log('outside');
  }

  function isInside(x,y,z) {
    let x1 = 10, x2 = 50;
    let y1 = 20, y2 = 80;
    let z1 = 15, z2 = 50;

    let isInsideX = x1 <= x && x <= x2;
    let isInsideY = y1 <= y && y <= y2;
    let isInsideZ = z1 <= z && z <= z2;

    return (isInsideX && isInsideY && isInsideZ);
  }
}