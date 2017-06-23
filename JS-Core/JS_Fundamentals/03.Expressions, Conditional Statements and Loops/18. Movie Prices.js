function moviePrices([title, day]) {

  let movies = {
    'the godfather' : [12, 10, 15, 12.50, 15, 25, 30],
    "schindler's list" : [8.50, 8.50, 8.50, 8.50, 8.50, 15, 15],
    'casablanca' : [8, 8, 8, 8, 8, 10, 10],
    'the wizard of oz' : [10, 10, 10, 10, 10, 15, 15]
  };
  title = title.toLowerCase();
  if (movies[title] === undefined) {
    console.log('There is no such movie');
    return;
  }
  
  let movieDates = movies[title];

  switch (day.toLowerCase()) {
    case 'monday':
      console.log(movieDates[0]);
      break;
    case 'tuesday':
      console.log(movieDates[1]);
      break;
    case 'wednesday':
      console.log(movieDates[2]);
      break;
    case 'thursday':
      console.log(movieDates[3]);
      break;
    case 'friday':
      console.log(movieDates[4]);
      break;
    case 'saturday':
      console.log(movieDates[5]);
      break;
    case 'sunday':
      console.log(movieDates[6]);
      break;
    default: console.log('error');
      break;

  }
}

moviePrices(['The Godfather', 'monday']);