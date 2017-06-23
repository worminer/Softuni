function numbersPrinter(endNumber) {
  let output = '';
  for (let i=1; i <= endNumber; i++){
    output += i;
  }
  console.log(output)
}
numbersPrinter(11);