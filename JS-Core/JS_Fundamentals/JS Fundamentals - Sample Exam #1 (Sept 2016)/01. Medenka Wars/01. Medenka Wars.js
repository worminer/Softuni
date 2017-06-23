function medenkaWars(attacks) {
  const medenkaDMG = 60;
  const africanAmericanLordName = 'Naskor';// to be politically correct
  const whiteLordName = 'Vitkor';



  let whiteSideDMG = 0;
  let africanAmericanSideDMG = 0;
  let africanAmericanLordConsecutiveAttacks = 0;
  let whiteLordConsecutiveAttacks = 0;
  let africanAmericanLordLastMedenkas = 0;
  let whiteLordLastMedenkas = 0;

  for (let attack of attacks) {
    let [numOfMedenkas, side, wordMedenkas] = attack.split(" ");
    if (wordMedenkas !== 'medenkas') {
      continue;
    }

    if (side === 'white') {
      whiteLordConsecutiveAttacks++;

      if (numOfMedenkas !== whiteLordLastMedenkas) {
        whiteLordConsecutiveAttacks = 1;
      }
      whiteLordLastMedenkas = numOfMedenkas;


      if (whiteLordConsecutiveAttacks === 2) {
        whiteLordConsecutiveAttacks = 0;
        whiteSideDMG += numOfMedenkas * medenkaDMG * 2.75;

      } else {
        whiteSideDMG += numOfMedenkas * medenkaDMG;
      }

    } else if (side === 'dark') {

      africanAmericanLordConsecutiveAttacks++;

      if (numOfMedenkas !== africanAmericanLordLastMedenkas) {
        africanAmericanLordConsecutiveAttacks = 1;
      }
      africanAmericanLordLastMedenkas = numOfMedenkas;

      if (africanAmericanLordConsecutiveAttacks === 5) {
        africanAmericanLordConsecutiveAttacks = 0;
        africanAmericanSideDMG += numOfMedenkas * medenkaDMG * 4.5;
      } else {
        africanAmericanSideDMG += numOfMedenkas * medenkaDMG;
      }
    } else {
      continue;
    }


  }



  if (whiteSideDMG > africanAmericanSideDMG) {
    // white site wins
    console.log(`Winner - ${whiteLordName}`);
    console.log(`Damage - ${whiteSideDMG}`);
  } else if (whiteSideDMG < africanAmericanSideDMG) {
    // dark side wins
    console.log(`Winner - ${africanAmericanLordName}`);
    console.log(`Damage - ${africanAmericanSideDMG}`);
  } else {
    //drow
  }
  //console.log(`Damage viktor- ${whiteSideDMG}`);
  //console.log(`Damage naskor- ${africanAmericanSideDMG}`);
}

medenkaWars([
  '2 dark medenkas',
  '1 white medenkas',
  '2 dark medenkas',
  '2 dark medenkas',
  '15 white medenkas',
  '2 dark medenkas',
  '2 dark medenkas',
]);