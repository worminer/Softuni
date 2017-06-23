'use strict';
function pyramidBuild(base, increment) {
  let stone = 0;
  let marble = 0;
  let lapisLazuli = 0;
  let gold = 0;
  let run = true;
  let flourCounter = 1;
  while(run) {
    let baseWH = base * base;
    let inside = (base - 2) * (base - 2);
    let perimeter = baseWH - inside;

    if (baseWH <= 4) {
      gold = baseWH;
      break;
    }

    if (flourCounter % 5 === 0) {
      stone +=inside;
      lapisLazuli += perimeter;
    } else {
      stone +=inside;
      marble += perimeter;
    }
    // console.log('flour: ' + flourCounter);
    // console.log('stone = '  + inside);
    // console.log('marbel = '  + perimeter);
    // console.log('lips = '  + lapisLazuli);
    // console.log()
    flourCounter++;
    base -= 2;
  }
  // display the data
  console.log(`Stone required: ${Math.ceil(stone * increment)}`);
  console.log(`Marble required: ${Math.ceil(marble * increment)}`);
  console.log(`Lapis Lazuli required: ${Math.ceil(lapisLazuli * increment)}`);
  console.log(`Gold required: ${Math.ceil(gold * increment)}`);
  console.log(`Final pyramid height: ${Math.floor(flourCounter * increment)}`);

}

pyramidBuild(11 , 1);
console.log( '1'.repeat(20));
pyramidBuild(11 , 0.75);
console.log( '2'.repeat(20));
pyramidBuild(12 , 1);
console.log( '3'.repeat(20));
pyramidBuild(23 , 0.5);
console.log( '4'.repeat(20));
