import Data from './Data';
const baseURL = '/pets';


class PetData {
  static create (pet) {
    return Data.post(`${baseURL}/create`, pet, true)
  }

  static list (page) {
    page = page || 1;
    return Data.get(`${baseURL}/all?page=${page}`, page, false)
  }
}

export default PetData;