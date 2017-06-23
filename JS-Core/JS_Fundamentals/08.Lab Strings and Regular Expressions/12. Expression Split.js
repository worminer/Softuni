function expressionSplit(code) {
  code.split(/[\s(),;\.]+/).filter(w => w != "").forEach(w => console.log(w));
}

expressionSplit('let sum = 4 * 4,b = "wow";')