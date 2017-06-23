function juicePacker(juicesArr) {
  let juiceTypes = [];
  let bottles = [];
  const juicePerBottle = 1000;
  for (let juice of juicesArr) {
    juice = juice.split(/\s=>\s/g);

    if (!juiceTypes.hasOwnProperty(juice[0])) {
      juiceTypes[juice[0]] = 0;
    }
    juiceTypes[juice[0]] += Number(juice[1]);

    if (juiceTypes[juice[0]] >= juicePerBottle) {
      if (!bottles.hasOwnProperty(juice[0])) {
        bottles[juice[0]] = 0;
      }
      bottles[juice[0]] += Math.floor(juiceTypes[juice[0]] / juicePerBottle);
      juiceTypes[juice[0]] = juiceTypes[juice[0]] % juicePerBottle;
    }
  }
  for (let type in bottles) {
    console.log(`${type} => ${bottles[type]}`);
  }
  // console.log(`${juiceType} => ${bottles}`);
}


juicePacker(
  [
    'Orange => 2000',
    'Peach => 1432',
    'Banana => 450',
    'Peach => 600',
    'Strawberry => 549'
  ]
);
console.log('***********')
juicePacker(
    [
      'Kiwi => 234',
      'Pear => 2345',
      'Watermelon => 3456',
      'Kiwi => 4567',
      'Pear => 5678',
      'Watermelon => 6789',

    ]
);