export default {
  email: (email) =>{
    if (!email || email === '') {
      return 'E-mail cannot be empty.';
    }
    let emailPattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@(([[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!emailPattern.test(email)) {
      return "This is not an valid e-mail."
    }
    return true;
  },
  name: (name, minLength = 5, maxLength = 30) =>{
    if (!name || name === '') {
      return 'Name cannot be empty.';
    }
    let namePattern = /^[a-zA-Z ]+$/;
    if (!namePattern.test(name)) {
      return "Name can be only be Letters."
    }
    if (name.length < minLength) {
      return `Name cannot be shorter then ${minLength} symbols.`
    }
    if (name.length > maxLength) {
      return `Name cannot be longer then ${maxLength} symbols.`
    }
    return true;
  },
  password: (password, length = 4) => {
    length = Number(length) || 1;
    if (!password || password === '') {
      return 'Password cannot be empty.';
    }
    else if (password.length < length) {
      return `Password cannot be less then ${length} symbols`
    }
    return true;
  },
  passwordsMatch: (password1, password2) => {
    // maybe a better name ?
    if (password1 !== password2) {
      return 'Passwords mismatch.';
    }
    return true
  },
  carMake: (make, minLength, maxLength) =>{
    if (!make || make === '') {
      return 'Car make cannot be empty.(client side)';
    }
    if (minLength && make.length < minLength) {
      return `Car make must be more than ${minLength} symbols.(client side)`
    }
    if (maxLength && make.length > maxLength) {
      return `Car make must be less than ${maxLength} symbols.(client side)`
    }
    return true;
  },
  carModel: (model, minLength, maxLength) =>{
    if (!model || model === '') {
      return 'Car Model cannot be empty.(client side)';
    }
    if (minLength && model.length < minLength) {
      return `Car Model must be more than ${minLength} symbols.(client side)`
    }
    if (maxLength && model.length > maxLength) {
      return `Car Model must be less than ${maxLength} symbols.(client side)`
    }
    return true;
  },
  carEngine: (engine, minLength, maxLength) =>{
    if (!engine || engine === '') {
      return 'Car Engine cannot be empty.(client side)';
    }
    if (minLength && engine.length < minLength) {
      return `Car Engine must be more than ${minLength} symbols.(client side)`
    }
    if (maxLength && engine.length > maxLength) {
      return `Car Engine must be less than ${maxLength} symbols.(client side)`
    }
    return true;
  },
}