import Data from './Data';
const baseURL = '';


class CarData {

  static getStats () {
    return Data.get(`${baseURL}/stats`, false)
  }
}

export default CarData;