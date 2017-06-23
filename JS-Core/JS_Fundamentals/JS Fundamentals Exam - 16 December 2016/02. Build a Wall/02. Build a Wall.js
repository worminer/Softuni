function wallCalc(wallParts) {
  const maxWallHeight = 30;
  const concretePerFoot = 195;
  const pesosPerCubicFoot = 1900;
  
  wallParts = wallParts.map(Number);

  let concretePerDay = [];
  let days = 0;
  let loop = true;
  while(loop){
    loop = false;
    for (let index in wallParts) {
      if (wallParts[index] < maxWallHeight) {
        if (concretePerDay[days] === undefined) {
          concretePerDay[days] = 0;
        }
        concretePerDay[days] += Number(concretePerFoot);
      }
      wallParts[index]++;
    }
    days++;
    wallParts.forEach(e => e < maxWallHeight ? loop = true: '');
  }
  console.log(concretePerDay.join(', '));
  console.log(concretePerDay.reduce((a, b) => a + b) * pesosPerCubicFoot + ' pesos')

}


wallCalc([21, 25, 28]);
