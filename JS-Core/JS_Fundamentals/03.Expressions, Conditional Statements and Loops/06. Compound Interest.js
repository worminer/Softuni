function calculate([p,i,n,t]) {
  [p,i,n,t] = [p,i,n,t].map(Number);

  let interest = p * Math.pow((1 + (i / (100 * 12 /n))),12 / n * t);

  console.log(interest.toFixed(2));
}

calculate([1500, 4.3, 3, 6]);