function solve(input) {
  let numbers = [];
  for (let line of input) {
    if (Number(line) === line) {
      numbers.push(line);
    } else {
      if (numbers.length < 2) {
        console.log('Error: not enough operands!')
        return ;
      }
      let firstOperand = numbers.pop();
      let secondOperand = numbers.pop();

      switch (line){
        case '+':
          numbers.push(firstOperand + secondOperand);
          break;
        case '-':
          numbers.push(secondOperand - firstOperand);
          break;
        case '*':
          numbers.push(firstOperand * secondOperand);
          break;
        case '/':
          numbers.push(secondOperand / firstOperand);
          break;
      }
    }
  }

  if (numbers.length > 1) {
    console.log('Error: too many operands!');
    return;
  }
  console.log(numbers[0]);
}

solve([31, 2, '+', 11, '/'] );
console.log('*************');
solve([  -1,  1,  '+',  101,  '*',  18,  '+',  3,  '/']);
console.log('*************');
solve([3, 4, '+']);
console.log('*************');
solve([5, 3, 4, '*', '-' ]);
console.log('*************');
solve([3, 4,4, '+']);
console.log('*************');
solve([3, 4, '+', '+']);