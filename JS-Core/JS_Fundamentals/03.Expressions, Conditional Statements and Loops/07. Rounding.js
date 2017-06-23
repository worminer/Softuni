function round(params) {
  let [number, precision] = params;
  if (precision > 15) {
    precision = 15;
  }
  number = number.toFixed(precision);
  console.log(+number);
}