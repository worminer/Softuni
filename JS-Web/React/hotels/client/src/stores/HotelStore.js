import {EventEmitter} from 'events';
import dispatcher from '../dispatcher';
import HotelActions from '../actions/HotelActions';
import HotelData from  '../data/HotelData';


class HotelStore extends  EventEmitter{
  handleAction (action) {
    switch (action.type){
      case HotelActions.types.CREATE_HOTEL : {
        this.create(action.hotel);
        break;
      }
      case HotelActions.types.LIST_HOTELS : {
        this.listPage(action.page);
        break;
      }
      case HotelActions.types.HOTEL_DETAILS : {
        this.details(action.id);
        break;
      }
      case HotelActions.types.CREATE_COMMENT : {
        this.createComment(action.comment,action.id);
        break;
      }
      default: break;
    }
  }

  create(hotel) {
    HotelData
      .create(hotel)
      .then(data => this.emit(this.eventTypes.HOTEL_CREATED, data));
  }
  createComment(comment,id) {
    HotelData
    .createComment(comment,id)
    .then(data => this.emit(this.eventTypes.COMMENT_CREATED, data));
  }
  listPage(page) {
    page = parseInt(page,10) || 1;
    HotelData
      .listPage(page)
      .then(data => this.emit(this.eventTypes.HOTELS_FETCHED, data));
  }
  details(id) {
    HotelData
    .details(id)
    .then(data => this.emit(this.eventTypes.HOTEL_DETAILS_FETCHED, data));
  }

}

let hotelStore = new HotelStore();
hotelStore.eventTypes = {
  HOTEL_CREATED: 'is_hotel_created',
  HOTELS_FETCHED: 'are_hotels_fetched',
  HOTEL_DETAILS_FETCHED: 'are_hotel_details_fetched',
  COMMENT_CREATED: 'is_comment_created'
};

dispatcher.register(hotelStore.handleAction.bind(hotelStore));
export default hotelStore;