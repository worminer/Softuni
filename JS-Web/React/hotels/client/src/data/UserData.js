import Data from './Data';
const baseURL = '/auth';


class UserData {
  static register (user) {
   return Data.post(`${baseURL}/signup`, user)
  }

  static login (user) {
    return Data.post(`${baseURL}/login`, user)
  }
}

export default UserData;