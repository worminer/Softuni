export default {
  email: (email) => {
    if (!email || email === '') {
      return 'E-mail cannot be empty.';
    }
    let emailPattern = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@(([[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    if (!emailPattern.test(email)) {
      return "This is not an valid e-mail."
    }
    return true;
  },
  name: (name, minLength = 5, maxLength = 30) => {
    if (!name || name === '') {
      return 'Name cannot be empty.';
    }
    let namePattern = /^[a-zA-Z0-9 ]+$/; // or \w for short
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
  description: (text, minLength = 5, maxLength = null) => {
    if (!text || text === '') {
      return 'Description cannot be empty.';
    }

    if (text.length < minLength) {
      return `Description cannot be shorter then ${minLength} symbols.`
    }
    if (maxLength!== null && text.length > maxLength) {
      return `Description cannot be longer then ${maxLength} symbols.`
    }
    return true;
  },
}