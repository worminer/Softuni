function removeX(data ) {
  let matrix = [];
  let clearItems = new Map;
  for (let row of data) {
    matrix.push(row.split(''))
  }


  for (let rowNum = 0; rowNum < matrix.length; rowNum++) {
    for (let colNum = 0; colNum < matrix[rowNum].length; colNum++) {
      let item = matrix[rowNum][colNum].toLowerCase();
      let removeItemsRight = new Map;
      let removeItemsLeft = new Map;
      // check if this is a proper symbol
      if (item.match(/\S/) === null) {
        continue;
      }

      // check if there is enough space for X
      if (matrix[rowNum + 1] === undefined ||
          matrix[rowNum + 2] === undefined) {
        // there is not enough rows
        continue;
      }
      //Try to go right..
      if (matrix[rowNum][colNum + 2]     !== undefined &&
          matrix[rowNum + 1][colNum + 1] !== undefined &&
          matrix[rowNum + 2][colNum + 2] !== undefined) {
        //there is enough space for X going to right
        if (
            matrix[rowNum][colNum + 2].toLowerCase()      === item &&
            matrix[rowNum + 1][colNum + 1].toLowerCase()  === item &&
            matrix[rowNum + 2][colNum].toLowerCase()      === item &&
            matrix[rowNum + 2][colNum + 2].toLowerCase()  === item
        )
        {
          if (!clearItems.has(rowNum)) {
            clearItems.set(rowNum,new Set())
          }
          if (!clearItems.has(rowNum + 1)) {
            clearItems.set(rowNum + 1,new Set())
          }

          if (!clearItems.has(rowNum + 2)) {
            clearItems.set(rowNum + 2,new Set())
          }
          clearItems.get(rowNum).add(colNum);
          clearItems.get(rowNum).add(colNum + 2);
          clearItems.get(rowNum + 1).add(colNum + 1);
          clearItems.get(rowNum + 2).add(colNum);
          clearItems.get(rowNum + 2).add(colNum + 2);
        }
      }

    }

  }

  for (let [row,colSet] of clearItems) {
    for (let col of colSet) {
      matrix[row][col] = '';
    }
  }
  let result = '';
  matrix.forEach( e => result += e.join('') + '\n');
  console.log(result)
}
removeX([
  'abnbjs',
  'xoBab',
  'Abmbh',
  'aabab',
  'ababvvvv',
]);