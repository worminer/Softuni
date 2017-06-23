const fs = require('fs');
const dataFile = 'storage.dat';


let data = {};

let validateKeyAsString = (string) => {
  if (typeof string !== 'string') {
    throw new Error('Key must be a string');
  }
};

let put = (key, value) => {
  validateKeyAsString(key);

  if (data.hasOwnProperty(key)) {
    throw new Error('Key exists!');
  }

  data[key] = value;
};

function validateKeyExists(key) {
  if (!data.hasOwnProperty(key)) {
    throw new Error('Key could not be found!');
  }
}
let get = (key) => {
  validateKeyAsString(key);

  validateKeyExists(key);

  return data[key];
};

let update = (key, value) => {
  validateKeyAsString(key);

  validateKeyExists(key);
  data[key] = value;
};

let deleteItem = (key) => {
  validateKeyAsString(key);
  validateKeyExists(key);
  delete data[key];
};


let clear = () => {
  data = {};
};
let save = () => {
  let dataAsString = JSON.stringify(data);
  fs.writeFileSync(dataFile, dataAsString);
};
let load = () => {
  let dataAsString = fs.readFileSync(dataFile, 'utf8');
  data = JSON.parse(dataAsString);

};


module.exports = {
  put: put,
  get: get,
  update : update,
  delete : deleteItem,
  clear : clear,
  save : save,
  load : load
}