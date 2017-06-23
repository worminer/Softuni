function strArr(arr) {
  let delimer = arr.pop();
  let result = '';
  arr.forEach((r,i) => result += r.toString() + ( i === arr.length-1 ? '': delimer)  );
  console.log(result);
}

strArr(['One', "Two", "Three", "Four", "Five", "-"]);