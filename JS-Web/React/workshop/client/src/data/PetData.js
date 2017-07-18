import Data from './Data';
const baseURL = '/pets';


class PetData {
  static create (pet) {
    return Data.post(`${baseURL}/create`, pet, true)
  }

  static list (page) {
    page = page || 1;
    let data = Data.get(`${baseURL}/all?page=${page}`, page, false);
    return data;
  }

  static details (id) {
    id = id || 1;
    return Data.get(`${baseURL}/details/${id}`, id, true);
  }

  static addComment (id, comment) {
    id = id || 1;
      return Data.post(`${baseURL}/details/${id}/comments/create`, comment, true);
  }

  static fetchComments (id) {
  id = id || 1;
  return Data.get(`${baseURL}/details/${id}/comments`,id, true);
}
}

export default PetData;