import {EventEmitter} from 'events';
import dispatcher from '../dispatcher';
import userActions from '../actions/UserActions';
import UserData from  '../data/UserData';


class UserStore extends  EventEmitter{
  handleAction (action) {
    switch (action.type){
      case userActions.types.REGISTER_USER : {
        this.register(action.user);
        break;
      }
      case userActions.types.LOGIN_USER : {
        this.login(action.user);
        break;
      }
      default: break;
    }
  }

  register(user) {
    UserData.register(user).then( data => this.emit(this.eventTypes.USER_REGISTERED, data));
  }

  login(user) {
    UserData.login(user).then( data => this.emit(this.eventTypes.USER_LOGGED, data));
  }
}

let userStore = new UserStore();
userStore.eventTypes = {
  USER_REGISTERED: 'is_user_registered',
  USER_LOGGED: 'is_user_logged'
};

dispatcher.register(userStore.handleAction.bind(userStore));
export default userStore;