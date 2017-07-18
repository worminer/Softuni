import Data from './Data';
const baseURL = '/cars';


class CarData {
  static create (car) {
    return Data.post(`${baseURL}/create`, car, true)
  }
  static deleteCar (id) {
    return Data.post(`${baseURL}/delete/${id}`, {}, true)
  }
  static likeThis (id) {
    return Data.post(`${baseURL}/details/${id}/like`, {}, true)
  }
  static createComment (comment,id) {
    return Data.post(`${baseURL}/details/${id}/reviews/create`, comment, true)
  }
  static listPage (page, search) {
    page = parseInt(page,10) || 1;
    let searchParam = search? `&search=${search}` : '';
    return Data.get(`${baseURL}/all?page=${page}${searchParam}`, false)
  }

  static details (id) {
    id = parseInt(id,10) || 1;
    return Data.get(`${baseURL}/details/${id}`, true)
  }
  static getReviews (id) {
    id = parseInt(id,10) || 1;
    return Data.get(`${baseURL}/details/${id}/reviews`, true)
  }
  static getMyCars () {
    return Data.get(`${baseURL}/mine/`, true)
  }
}

export default CarData;