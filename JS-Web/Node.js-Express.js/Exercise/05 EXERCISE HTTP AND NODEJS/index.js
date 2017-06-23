const storage = require('./storage');

// test put functionality
console.log('TEST:put');
storage.put('first', 'first value');
storage.put('second', 'second value');
storage.put('third', 'third value');

try{
  storage.put(22, 'not a string value');
}catch(e) {
  console.log(e.message);
}

//test get functionality
console.log('Test:get');
console.log(storage.get('second'));

try{
  console.log(storage.get('nonExistingThing'));
}catch(e) {
  console.log(e.message);
}

//test update
console.log('Test: Update');
storage.update('second',"second is updated successfully");
console.log(storage.get('second'));

//test delete
try{
  storage.delete('third');
  console.log(storage.get('third'));

}catch(e) {
  console.log(e.message);
}

//test save
console.log('Test: Save');
storage.save();
//save load
console.log('Test: clear and load');
storage.clear();
storage.load();
console.log(storage.get('second'));
