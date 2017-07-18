import dispatcher from './../dispatcher';

const UserActions = {
  types: {
    CREATE_PET: 'CREATE_PET',
    LIST_PETS: 'LIST_PETS',
    PET_DETAILS: 'PET_DETAILS',
    PET_ADD_COMMENT: 'PET_ADD_COMMENT',
    PET_FETCH_COMMENTS: 'PET_FETCH_COMMENTS'
  },

  create(pet) {
    dispatcher.dispatch({
      type: this.types.CREATE_PET,
      pet
    })
  },

  list(page) {
    page = page || 1;
    dispatcher.dispatch({
      type: this.types.LIST_PETS,
      page
    })
  },

  details(id) {
    id = id || 1;
    dispatcher.dispatch({
      type: this.types.PET_DETAILS,
      id
    })
  },
  addComment(id,comment) {
    id = id || 1;
    dispatcher.dispatch({
      type: this.types.PET_ADD_COMMENT,
      id,
      comment
    })
  },
  fetchComments(id) {
    id = id || 1;
    dispatcher.dispatch({
      type: this.types.PET_FETCH_COMMENTS,
      id
    })
  }

};

export default UserActions;