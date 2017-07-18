import dispatcher from './../dispatcher';

const HomeActions = {
  types: {
    GET_STATISTICS : 'GET_STATISTICS'
  },

  getStats() {
    dispatcher.dispatch({
      type: this.types.GET_STATISTICS
    })
  }
};

export default HomeActions;