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
      case petActions.types.PET_DETAILS : {
        this.details(action.id);
        break;
      }
      case petActions.types.PET_ADD_COMMENT : {
        this.addComment(action.id,action.comment);
        break;
      }
      case petActions.types.PET_FETCH_COMMENTS : {
        this.fetchComments(action.id);
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
  details(id) {
    id = id || 1;
    PetData
      .details(id)
      .then(data => this.emit(this.eventTypes.PET_FETCHED_DETAILS, data));
  }

  addComment(id, comment) {
    id = id || 1;
    PetData
      .addComment(id,comment)
      .then(data => this.emit(this.eventTypes.PET_ADD_COMMENT, data));
  }

  fetchComments(id) {
    id = id || 1;
    PetData
      .fetchComments(id)
      .then(data => this.emit(this.eventTypes.PET_FETCH_COMMENTS, data));
  }
}

let petStore = new PetStore();
petStore.eventTypes = {
  PET_CREATED: 'is_pet_created',
  PETS_FETCHED: 'are_pets_fetched',
  PET_FETCHED_DETAILS: 'are_details_fetched',
  PET_ADD_COMMENT : 'is_pet_comment_added',
  PET_FETCH_COMMENTS : 'is_pet_comments_fetched'
};

dispatcher.register(petStore.handleAction.bind(petStore));
export default petStore;