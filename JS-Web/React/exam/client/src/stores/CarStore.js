import {EventEmitter} from 'events';
import dispatcher from '../dispatcher';
import CarActions from '../actions/CarActions';
import CarData from  '../data/CarData';


class CarStore extends  EventEmitter{
  handleAction (action) {
    switch (action.type){
      case CarActions.types.CREATE_CAR : {
        this.create(action.car);
        break;
      }
      case CarActions.types.LIST_CARS : {
        this.listPage(action.page,action.search);
        break;
      }
      case CarActions.types.CAR_DETAILS : {
        this.details(action.id);
        break;
      }
      case CarActions.types.CAR_LIKE_THIS : {
        this.likeThis(action.id);
        break;
      }
      case CarActions.types.CREATE_CAR_REVIEWS : {
        this.createComment(action.comment,action.id);
        break;
      }
      case CarActions.types.GET_CAR_REVIEWS : {
        this.getReviews(action.id);
        break;
      }
      case CarActions.types.GET_USER_CARS : {
        this.getMyCars();
        break;
      }
      case CarActions.types.DELETE_CAR : {
        this.deleteCar(action.id);
        break;
      }
      default: break;
    }
  }

  create(car) {
    CarData
      .create(car)
      .then(data => this.emit(this.eventTypes.CAR_CREATED, data));
  }
  likeThis(id) {
    CarData
      .likeThis(id)
      .then(data => this.emit(this.eventTypes.CAR_LIKED_THIS, data));
  }
  createComment(comment,id) {
    CarData
    .createComment(comment,id)
    .then(data => this.emit(this.eventTypes.CAR_COMMENT_CREATED, data));
  }
  getReviews(id) {
    CarData
    .getReviews(id)
    .then(data => this.emit(this.eventTypes.CAR_REVIEWS_FETCHED, data));
  }
  listPage(page, search) {
    page = parseInt(page,10) || 1;
    CarData
      .listPage(page,search)
      .then(data => this.emit(this.eventTypes.CARS_FETCHED, data));
  }
  details(id) {
    CarData
    .details(id)
    .then(data => this.emit(this.eventTypes.CAR_DETAILS_FETCHED, data));
  }
  getMyCars() {
    CarData
    .getMyCars()
    .then(data => this.emit(this.eventTypes.MY_CARS_FETCHED, data));
  }
  deleteCar(id) {
    CarData
    .deleteCar(id)
    .then(data => this.emit(this.eventTypes.MY_CAR_DELETED, data));
  }
}

let carStore = new CarStore();
carStore.eventTypes = {
  CAR_CREATED: 'is_car_created',
  CAR_LIKED_THIS: 'like_this_car',
  CARS_FETCHED: 'are_cars_fetched',
  CAR_DETAILS_FETCHED: 'are_car_details_fetched',
  CAR_COMMENT_CREATED: 'is_car_comment_created',
  CAR_REVIEWS_FETCHED: 'are_car_reviews_fetched',
  MY_CARS_FETCHED: 'are_my_cars_fetched',
  MY_CAR_DELETED: 'is_my_car_deleted'
};

dispatcher.register(carStore.handleAction.bind(carStore));
export default carStore;