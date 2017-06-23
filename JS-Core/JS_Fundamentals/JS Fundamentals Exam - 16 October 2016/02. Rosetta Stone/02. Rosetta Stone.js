function solve(arr) {
  let lines = Number(arr.shift());
  let template = [];
  let matrix = [];
  let decoderMap = [];

  // populating decoder map
  decoderMap.push(' ');

  for (let i = 65; i < 65+26; i++) {
    decoderMap.push(String.fromCharCode(i))

  }

  //get the template items
  for (let i = 0; i < lines; i++) {
    template.push(arr.shift().split(' '));
  }

  // populate the matrix
  for (let line of arr) {
    matrix.push(line.split(' ').map(Number))
  }

  // convert the matrix
  for (let rowNum = 0; rowNum < matrix.length; rowNum++) {
    let row = matrix[rowNum];
    let rowTemplateIterator = rowNum;
    if (rowTemplateIterator > template.length -1) {
      rowTemplateIterator = rowNum % (template.length)
    }
    let templateRow = template[rowTemplateIterator];

    for (let colNum = 0; colNum < row.length; colNum++) {
      let item = Number(row[colNum]);
      let colTemplateIterator = colNum;
      if (colTemplateIterator > templateRow.length -1) {
        colTemplateIterator = colNum % templateRow.length
      }
      let templateItem = Number(templateRow[colTemplateIterator]);

      matrix[rowNum][colNum] = decode(decoderMap, item + templateItem);


    }

  }

  function decode(decoderMap,number) {

    if (number >= decoderMap.length) {
      number = number % decoderMap.length;
    }
    return decoderMap[number];
  }
  let result = '';
  matrix.forEach(e => result += e.join(''));
  console.log(result);
}

solve([
      '2',
      '59 36',
      '82 52',
      '4 18 25 19 8',
      '4 2 8 2 18',
      '23 14 22 0 22',
      '2 17 13 19 20',
      '0 9 0 22 22'
]);

solve([
  '1',
  '1 3 13',
  '12 22 14 13 25 0 4 24 23',
  '18 24 2 25 22 0 0 11 18',
  '8 25 6 26 8 23 13 4 14',
  '14 3 14 10 6 1 6 16 14',
  '11 12 2 10 24 2 13 24 0',
  '24 24 10 14 15 25 18 24 12',
  '4 24 0 8 4 22 19 22 14',
  '0 11 18 26 1 19 18 13 15',
  '8 15 14 26 24 14 26 24 14',
])

function decode(decoderMap,number) {
  console.log(number)
  if (number > decoderMap.length) {
    number = number % decoderMap.length;
  }
  return decoderMap[number];
}