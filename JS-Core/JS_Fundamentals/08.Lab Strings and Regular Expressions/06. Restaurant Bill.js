function resturantBill(arr) {
  let products = [];
  let sum = 0;
  for (let i = 0; i < arr.length; i += 2 ) {
    products.push(arr[i]);
    sum += Number(arr[i+1]);
  }
  console.log(`You purchased ${products.join(', ')} for a total sum of ${sum}`);
}

resturantBill(['Beer Zagorka', '2.65', 'Tripe soup', '7.80','Lasagna', '5.69']);