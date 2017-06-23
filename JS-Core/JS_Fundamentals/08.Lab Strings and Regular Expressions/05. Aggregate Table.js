function aggregate(arr) {
  let sum = 0;
  let cities = [];
  for (let row of arr) {
    row = row.split('|').filter(e => e !== '');
    sum += Number(row[1]);
    cities.push(row[0]);
  }
  console.log(cities.map(s => s.trim()).join(', '));
  console.log(sum);
}

aggregate([
      '| Sofia           | 300',
      '| Veliko Tarnovo  | 500',
      '| Yambol          | 275'
    ]
);