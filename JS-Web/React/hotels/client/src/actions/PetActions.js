import dispatcher from './../dispatcher';

const UserActions = {
  types: {
    CREATE_PET: 'CREATE_PET',
    LIST_PETS: 'LIST_PETS'
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
  }
};

export default UserActions;