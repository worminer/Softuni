import {EventEmitter} from 'events';
import dispatcher from '../dispatcher';
import HomeActions from '../actions/HomeActions';
import HomeData from  '../data/HomeData';


class HomeStore extends  EventEmitter{
  handleAction (action) {
    switch (action.type){
      case HomeActions.types.GET_STATISTICS : {
        this.getStats();
        break;
      }
      default: break;
    }
  }

  getStats() {
    HomeData
      .getStats()
      .then(data => this.emit(this.eventTypes.CAR_CREATED, data));
  }
}

let homeStore = new HomeStore();
homeStore.eventTypes = {
  HOME_STATS_RETRIEVED: 'are_home_stats_retrieved'
};

dispatcher.register(homeStore.handleAction.bind(homeStore));
export default homeStore;