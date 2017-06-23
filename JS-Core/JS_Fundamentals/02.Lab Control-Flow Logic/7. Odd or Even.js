function oddEven(num) {
  let remaining = num % 2;
  if (remaining === 0) {
    console.log("even");
  } else if (remaining === Math.round(remaining)) {
    console.log("odd");
  } else {
    console.log("invalid")
  }
}