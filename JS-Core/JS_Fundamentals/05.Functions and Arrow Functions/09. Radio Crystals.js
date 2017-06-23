function radioCrystals(input) {
  input = input.map(Number);
  for (let i = 1; i < input.length; i++) {
    let desiredSize = input[0];
    let size = input[i];
    console.log(`Processing chunk ${size} microns`);
    let times = 0;
    let cutted = cut(size);

    while (cutted >= desiredSize || parseInt(desiredSize - cutted === 1)) {
      size = cut(size);
      cutted = cut(size);
      ++times;
    }

    if (times > 0) {
      console.log(`Cut x${times}`);
      size = wash(size);
    }

    times = 0;
    let lapped = lap(size);
    while (lapped >= desiredSize || parseInt(desiredSize - lapped === 1)) {
      size = lap(size);
      lapped = lap(size);
      ++times;
    }

    if (times > 0) {
      console.log(`Lap x${times}`);
      size = wash(size);
    }

    times = 0;
    let grinded = grind(size);
    while (grinded >= desiredSize || parseInt(desiredSize - grinded === 1)) {
      size = grind(size);
      grinded = grind(size);
      ++times;
    }

    if (times > 0) {
      console.log(`Grind x${times}`);
      size = wash(size);
    }

    times = 0;
    let etched = etch(size);
    while (etched >= desiredSize || parseInt(desiredSize - etched === 1)) {
      size = etch(size);
      etched = etch(size);
      ++times;
    }

    if (times > 0) {
      console.log(`Etch x${times}`);
      size = wash(size);
    }

    if (size === desiredSize - 1) {
      xray(size);
      console.log('X-ray x1');
    }

    console.log(`Finished crystal ${desiredSize} microns`);
  }

  function cut(size) {
    return size / 4;
  }

  function lap(size) {
    return size * 0.80;
  }

  function grind(size) {
    return size - 20;
  }

  function etch(size) {
    return size - 2;
  }

  function xray(size) {
    return size + 1;
  }

  function wash(size) {
    console.log('Transporting and washing');
    return Math.floor(size);
  }
}

//radioCrystals(['1375','50000']);
//radioCrystals(['1000', '4000', '8100']);