function solve(array) {

  let result = array
      .map(Number)
      .sort((a,b) => a - b)
      .slice(0,2);

  console.log(result.join(' '));
}

solve(['30', '15', '50', '5']);