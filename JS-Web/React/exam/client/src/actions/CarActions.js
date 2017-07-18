import dispatcher from './../dispatcher';

const CarActions = {
  types: {
    CREATE_CAR:'CREATE_CAR',
    LIST_CARS: 'LIST_CARS',
    CAR_DETAILS: 'CAR_DETAILS',
    CAR_LIKE_THIS: 'CAR_LIKE_THIS',
    CREATE_CAR_REVIEWS: 'CREATE_CAR_REVIEWS',
    GET_CAR_REVIEWS: 'GET_CAR_REVIEWS',
    GET_USER_CARS: 'GET_USER_CARS',
    DELETE_CAR: 'DELETE_CAR'
  },

  create(car) {
    dispatcher.dispatch({
      type: this.types.CREATE_CAR,
      car
    })
  },
  deleteCar(id) {
    dispatcher.dispatch({
      type: this.types.DELETE_CAR,
      id
    })
  },
  likeThis(id) {
    dispatcher.dispatch({
      type: this.types.CAR_LIKE_THIS,
      id
    })
  },
  createComment(comment,id) {
    dispatcher.dispatch({
      type: this.types.CREATE_CAR_REVIEWS,
      comment,
      id
    })
  },
  getReviews(id) {
    dispatcher.dispatch({
      type: this.types.GET_CAR_REVIEWS,
      id
    })
  },

  listPage(page,search) {
    page = parseInt(page,10) || 1;
    dispatcher.dispatch({
      type: this.types.LIST_CARS,
      page,
      search
    })
  },
  details(id) {
    dispatcher.dispatch({
      type: this.types.CAR_DETAILS,
      id
    })
  },
  getMyCars() {
    dispatcher.dispatch({
      type: this.types.GET_USER_CARS
    })
  }
};

export default CarActions;