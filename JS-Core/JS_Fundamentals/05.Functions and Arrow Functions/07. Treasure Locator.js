function locate(input) {
  for (let i = 0; i < input.length; i+=2) {
    let x = input[i];
    let y = input[i + 1];

    if (tuvalu(x, y))
      console.log("Tuvalu");
    else if (tokelau(x, y))
      console.log("Tokelau");
    else if (samoa(x, y))
      console.log("Samoa");
    else if (tonga(x, y))
      console.log("Tonga");
    else if (cook(x, y))
      console.log("Cook");
    else
      console.log("On the bottom of the ocean");
  }

  function tuvalu(x, y) {
    let isInsideX = x <= 3 && x >= 1;
    let isInsideY = y <= 3 && y >= 1;

    return isInsideX && isInsideY;
  }

  function tokelau(x, y) {
    let isInsideX = x <= 9 && x >= 8;
    let isInsideY = y <= 1 && y >= 0;

    return isInsideX && isInsideY;
  }

  function samoa(x, y) {
    let isInsideX = x <= 7 && x >= 5;
    let isInsideY = y <= 6 && y >= 3;

    return isInsideX && isInsideY;
  }

  function tonga(x, y) {
    let isInsideX = x <= 2 && x >= 0;
    let isInsideY = y <= 8 && y >= 6;

    return isInsideX && isInsideY;
  }

  function cook(x, y) {
    let isInsideX = x <= 9 && x >= 4;
    let isInsideY = y <= 8 && y >= 7;

    return isInsideX && isInsideY;
  }
}

locate([4, 2, 1.5, 6.5, 1, 3]);