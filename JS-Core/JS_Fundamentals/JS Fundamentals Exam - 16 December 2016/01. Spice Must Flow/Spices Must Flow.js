function spicesFlowCalc(startingYield) {
  const crewDaily = 26;
  let currentYield = Number(startingYield);
  let days = 0;
  let totalAmount = 0;

  while(currentYield >= 100 ){
    totalAmount += currentYield;
    currentYield -= 10;
    days++;
    totalAmount -= crewDaily;
  }
  if(days > 0){
    totalAmount -= crewDaily;
  }

  console.log(days);
  console.log(totalAmount);

}

spicesFlowCalc(111);