import dispatcher from './../dispatcher';

const HotelActions = {
  types: {
    CREATE_HOTEL:'CREATE_HOTEL',
    LIST_HOTELS: 'LIST_HOTELS',
    HOTEL_DETAILS: 'HOTEL_DETAILS',
    CREATE_COMMENT: 'CREATE_COMMENT'
  },

  create(hotel) {
    dispatcher.dispatch({
      type: this.types.CREATE_HOTEL,
      hotel
    })
  },
  createComment(comment,id) {
    dispatcher.dispatch({
      type: this.types.CREATE_COMMENT,
      comment,
      id
    })
  },

  listPage(page) {
    page = parseInt(page,10) || 1;
    dispatcher.dispatch({
      type: this.types.LIST_HOTELS,
      page
    })
  },
  details(id) {
    dispatcher.dispatch({
      type: this.types.HOTEL_DETAILS,
      id
    })
  }
};

export default HotelActions;