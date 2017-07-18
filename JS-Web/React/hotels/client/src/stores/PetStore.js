import {EventEmitter} from 'events';
import dispatcher from '../dispatcher';
import petActions from '../actions/PetActions';
import PetData from  '../data/PetData';


class PetStore extends  EventEmitter{
  handleAction (action) {
    switch (action.type){
      case petActions.types.CREATE_PET : {
        this.create(action.pet);
        break;
      }
      case petActions.types.LIST_PETS : {
        this.list(action.page);
        break;
      }

      default: break;
    }
  }

  create(pet) {
    PetData
      .create(pet)
      .then(data => this.emit(this.eventTypes.PET_CREATED, data));
  }
  list(page) {
    page = page || 1;
    PetData
      .list(page)
      .then(data => this.emit(this.eventTypes.PETS_FETCHED, data));
  }

}

let petStore = new PetStore();
petStore.eventTypes = {
  PET_CREATED: 'is_pet_created',
  PETS_FETCHED: 'are_pets_fetched'
};

dispatcher.register(petStore.handleAction.bind(petStore));
export default petStore;