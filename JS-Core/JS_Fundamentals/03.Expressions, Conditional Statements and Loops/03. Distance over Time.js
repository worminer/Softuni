function calcDistanceOverTime([speed1,speed2,time]) {
  [speed1,speed2,time] = [speed1,speed2,time].map(Number);
  let first = (speed1 * 1000) * (time / 60 / 60);
  let second = (speed2 * 1000) * (time / 60 / 60);
  let distance = Math.abs(first - second);

  console.log(distance);
}

calcDistanceOverTime([0, 60, 3600]);