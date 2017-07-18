import Data from './Data';
const baseURL = '/hotels';


class HotelData {
  static create (hotel) {
    return Data.post(`${baseURL}/create`, hotel, true)
  }
  static createComment (comment,id) {
    return Data.post(`${baseURL}/details/${id}/reviews/create`, comment, true)
  }
  static listPage (page) {
    page = parseInt(page,10) || 1;
    return Data.get(`${baseURL}/all?page=${page}`, false)
  }

  static details (id) {
    id = parseInt(id,10) || 1;
    return Data.get(`${baseURL}/details/${id}`, true)
  }
}

export default HotelData;