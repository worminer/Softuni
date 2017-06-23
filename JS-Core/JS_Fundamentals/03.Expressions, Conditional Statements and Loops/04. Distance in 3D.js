function calc3d([x1,y1,z1,x2,y2,z2]) {
  let x = Math.pow((x2 - x1),2);
  let y = Math.pow((y2 - y1),2);
  let z = Math.pow((z2 - z1),2);
  return Math.sqrt(x + y + z);;
}