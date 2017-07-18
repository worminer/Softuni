class Auth {
  static userTokenKey = 'token';
  static userDataKey = 'user';

  static setUser(user) {
    window.localStorage.setItem(this.userDataKey, JSON.stringify(user))
  }

  static getUser () {
    const userJson = window.localStorage.getItem(this.userDataKey);
    if (userJson) {
      return JSON.parse(userJson);
    }
    return {};
  }

  static removeUser () {
    window.localStorage.removeItem(this.userDataKey)
  }
  static authenticateUser (token) {
    window.localStorage.setItem(this.userTokenKey, token);
  }

  static isUserAuthenticated(){
    return window.localStorage.getItem(this.userTokenKey)
  }

  static deauthenticateUser () {
    window.localStorage.removeItem(this.userTokenKey)
  }

  static getToken () {
    return window.localStorage.getItem(this.userTokenKey)
  }
}

export default Auth;