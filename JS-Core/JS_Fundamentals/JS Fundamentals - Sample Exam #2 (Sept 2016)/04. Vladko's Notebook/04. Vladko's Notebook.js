'use strict';
function aggregate(data) {
  let db = new Map();
  for (let row of data) {
    let [color, action , info] = row.split('|');


    if (!db.has(color)) {
      db.set(color, new Map());
    }
    let currentPage = db.get(color);

    if (action === 'name') {
      currentPage.set('name', info)
    } else if (action === 'age') {
      currentPage.set('age', Number(info))
    } else if (action === 'win') {
      if (!currentPage.has('win')) {
        currentPage.set('win', [])
      }
      if (!currentPage.has('opponents')) {
        currentPage.set('opponents', [])
      }
      currentPage.get('win').push(info);
      currentPage.get('opponents').push(info);

    } else if (action === 'loss') {
      if (!currentPage.has('loss')) {
        currentPage.set('loss', [])
      }
      if (!currentPage.has('opponents')) {
        currentPage.set('opponents', [])
      }
      currentPage.get('loss').push(info);
      currentPage.get('opponents').push(info);
    }
  }

  // calculate the rank
  for (let page of db) {
    let player = page[1];

    let pWin = 0;
    let pLoss = 0;
    if (player.has('win')) {
      pWin = player.get('win').length
    }

    if (player.has('loss')) {
      pLoss = player.get('loss').length;
    }
    
    player.set('rank',  ((pWin+1) / (pLoss+1)).toFixed(2))

  }
  // create the output
  let jsonResults = new Array();
  db = new Map([...db].sort((el1, el2) => el1[0].localeCompare(el2[0])))
  for (let page of db) {
    let [color, info] = Array.from(page);

    if (!info.has('rank')) {
      continue;
    }

    let tempResult = `"${color}":{`;
    if (info.has('age')) {
      tempResult += `"age":"${info.get('age')}",`;
    } else {
      continue;
    }

    if (info.has('name')) {
      tempResult += `"name":"${info.get('name')}",`;
    } else {
      continue;
    }

    if (info.has('opponents')) {
      let opponents = info.get('opponents').sort();
      tempResult += `"opponents":["${opponents.join('","')}"],`;
    } else {
      tempResult += `"opponents":[],`;
    }

    if (info.has('rank')) {
      tempResult += `"rank":"${info.get('rank')}"}`;
    }


    jsonResults.push(tempResult);
  }
  console.log(`{${jsonResults.join(',')}}`)
}

aggregate([
  'purple|age|99',
  'red|age|44',
  'blue|win|pesho',
  'blue|win|mariya',
  'purple|loss|Kiko',
  'purple|loss|Kiko',
  'purple|loss|Kiko',
  'purple|loss|Yana',
  'purple|loss|Yana',
  'purple|loss|Manov',
  'purple|loss|Manov',
  'red|name|gosho',
  'blue|win|Vladko',
  'purple|loss|Yana',
  'purple|name|VladoKaramfilov',
  'blue|age|21',
  'blue|loss|Pesho',

]);