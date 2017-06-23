function ageFilter(minAge, name1, age1, name2, age2) {
  let people = [
    {
      name : name1,
      age : age1
    },{
      name : name2,
      age : age2
    }
  ]
  for (let person of people) {
    if (person.age >= minAge) {
      console.log(person)
    }
  }
}

ageFilter(12, 'Ivan', 15, 'Asen', 9);