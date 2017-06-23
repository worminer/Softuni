function heroesInventory(heroesDataArr) {
  let heroes = [];
  for (let heroData of heroesDataArr) {

    let parsedHeroData = heroData.split(/\s\/\s/g);
    let heroItems = [];
    if (parsedHeroData.length > 2) {
      heroItems = parsedHeroData[2].split(', ').map(e => e.toString())
    }
    let heroInventory = {
      name: parsedHeroData[0].toString(),
      level: Number(parsedHeroData[1]),
      items: heroItems
    };
    heroes.push(JSON.stringify(heroInventory));
  }
  return `[${heroes.join(',')}]`;
}

console.log(heroesInventory([
  'Isacc / 25 / Apple, GravityGun',
  'Derek / 12 / BarrelVest, DestructionSword',
  'Hes / 1 / Desolator, Sentinel, Antara',
]));