function killTheBunnies(targetsDataArr) {
  // if arr cell has 0 in in .. its death
  let bombs = targetsDataArr.pop().split(' ');
  let bunnyKiller = {damageDealt:0, targetsKilled:0};
  let targets = [];

  // sorting the arr with targets
  for (let targetLine of targetsDataArr) {
    targets.push(targetLine.split(' ').map(Number));
  }

  //blowing the bombs
  //bombs.forEach(position => blowBombs(targets, position, bunnyKiller));
  for (let bomb of bombs) {
    let [bombY, bombX] = bomb.split(',').map(Number);
    if (!isValidPointMatrix(targets,bombX,bombY)) {
      continue;
    }
    blowBombs(targets,bombX,bombY,bunnyKiller)
  }

  function blowBombs(targets, bombX, bombY, bunnyKiller) {
    let waveDamage = targets[bombY][bombX] > 0 ? targets[bombY][bombX]: 0;
    bunnyKiller.damageDealt += targets[bombY][bombX];
    bunnyKiller.targetsKilled++;
    targets[bombY][bombX] = 0;
    let wave = [];

    let xx = bombX - 1;
    let yy = bombY - 1;

    for (let j = 0; j< 3; j++) {
      for (let k = 0; k< 3; k++) {
        let pointX =xx + j;
        let pointY = yy + k;
        if (!isValidPointMatrix(targets,pointX,pointY)) {
          continue;
        }
        if (pointY === bombY && pointX === bombX) {
          continue;
        }

        wave.push({x:pointX, y:pointY})
      }
    }

    wave.forEach(pos => targets[pos.y][pos.x] -= waveDamage);

  }

  for (let targetRow of targets) {
    for (let target of targetRow) {
      if (target > 0) {
        bunnyKiller.targetsKilled++;
        bunnyKiller.damageDealt += target;
      }
    }
  }
  function isValidPointMatrix(arr,x,y) {
    if (x < 0 || y < 0) {
      return false
    }
    if (y > arr.length -1 || x > arr[y].length -1) {
      return false
    }
    return true;
  }
  console.log(bunnyKiller.damageDealt);
  console.log(bunnyKiller.targetsKilled)
}

let arr = [
  '5 10 15 20',
  '10 10 10 10',
  '10 15 -10 10',
  '10 10 10 10 -10',
  '2,2 0,1 3,4',
];

//console.log(arr[3].split(' ').length)


killTheBunnies(arr);