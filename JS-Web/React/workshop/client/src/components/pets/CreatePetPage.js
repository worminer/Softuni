import React,{Component} from 'react';
import ShowMessage from '../common/ShowPopupMessage';

import CreatePetForm from './CreatePetForm';
import FormHelpers from "../common/forms/FormHelpers";

import PetActions from '../../actions/PetActions';
import PetStore from '../../stores/PetStore';

export default class CreatePetPage extends Component{
  constructor(props) {
    super(props);

    this.state = {
      pet: {
        name: '',
        age: '',
        type: '',
        image: '',
        breed: ''
      },
      errors: []
    };

    this.handleCreateResponse = this.handleCreateResponse.bind(this);
    PetStore.on(PetStore.eventTypes.PET_CREATED, this.handleCreateResponse);
  }

  componentWillUnmount() {
    PetStore.removeListener(PetStore.eventTypes.PET_CREATED, this.handleCreateResponse);
  }



  handleCreateResponse (data) {
    let errors = FormHelpers.extractFormErrorsFromData(data,this.state.errors);

    if (!data.success) {
      errors['message'] = data.message;
      this.setState({
        errors: errors
      })
    } else {
      console.log(data)
      ShowMessage.success(data.message);
      this.props.history.push(`/pets/details/${data.pet.id}`);
    }

  }

  handleFormChange (event) {
    FormHelpers.handleFormChange.bind(this)(event, 'pet');
  }

  handlePetCreate (event) {
    event.preventDefault();
    if(!this.validatePetData()) {
      return;
    }

    PetActions.create(this.state.pet);
  }

  validatePetData() {
    return true;

    // const user = this.state.user;
    // let isFormValid = true;
    // let errors = this.state.errors;

    //TODO: validate form
    // if (user.password !== user.confirmPassword) {
    //   errors['password'] = 'Passwords mismatch!';
    //   isFormValid = false;
    // } else {
    //   errors['password']= '';
    // }

    // if (Object.keys(errors).length > 0) {
    //   this.setState({
    //     errors
    //   });
    // }
    //
    // return isFormValid;
  }

  render () {
    return (
        <CreatePetForm
          pet={this.state.pet}
          errors={this.state.errors}
          onChange={this.handleFormChange.bind(this)}
          onSave={this.handlePetCreate.bind(this)}
          //form style config
          formClass="form-horizontal col-md-6 col-lg-offset-3"
          formLegend="Login"
          errorBoxMessageClass = 'errorBoxMessage'
          elementErrorClass="formFieldErrorText bg-danger"
        />
    )
  }
}