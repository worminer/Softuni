function drow(lines) {
  lines = Number(lines);
  let result = '';

  for (let i = 1; i <= lines; i++) {
    result += '*'.repeat(i) + '\n';
  }

  for (let i = lines - 1; i > 0; i--) {
    result += '*'.repeat(i) + '\n';
  }
  console.log(result);
}

drow(5);