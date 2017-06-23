function checkSpeedLimit([speed, area]) {
  function checkSpeed(speed, limit) {
    let diff = speed - limit;
    if (diff <= 0) {
     // hmm there must be a better way
    } else if (diff <= 20 ){
      console.log('speeding');
    } else if (diff <= 40) {
      console.log('excessive speeding');
    } else if (diff > 40) {
      console.log('reckless driving');
    }
  }

  speed = Number(speed);
  let limit = 0;
  switch(area) {
    case 'motorway':
      limit = 130;
      break;
    case 'interstate':
      limit = 90;
      break;
    case 'city':
      limit = 50;
      break;
    case 'residential': limit = 20;
      break;
  }
  checkSpeed(speed, limit);



}

