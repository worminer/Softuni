function specialSort(arr) {
  arr = arr.sort((a,b) => {
    return  a[0] <= b[0];
  }).sort((a,b) => {
    return a.length >= b.length;
  });
  arr.forEach(r => console.log(r.toString()));
}

specialSort(['Isacc', 'Theodor', 'Jack', 'Harrison', 'George']);
