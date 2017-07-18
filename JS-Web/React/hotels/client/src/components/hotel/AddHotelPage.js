import React,{Component} from 'react';
//forms
import Form from '../common/forms/Form';
import FormHelpers from '../common/forms/FormHelpers';
import FormInputElement from '../common/forms/FormInputElement';
import FormButtonSubmit from '../common/forms/FormButtonSubmit';
import FromTextAreaComponent from '../common/forms/FormTextAreaComponent';
//stores and actions
import HotelAction from '../../actions/HotelActions';
import HotelStore from '../../stores/HotelStore';
//validation
import validate from  '../../utill/validate';
//display messages
import ShowMessage from '../common/ShowPopupMessage';

export default class AddHotel extends Component {
  constructor(props) {
    super(props);

    this.state = {
      hotel: {
        name: '',
        description: '',
        image: '',
        numberOfRooms: ''
      },
      errors: {},
    };
    this.handleAddHotelResponse = this.handleAddHotelResponse.bind(this);
    HotelStore.on(HotelStore.eventTypes.HOTEL_CREATED,
      this.handleAddHotelResponse);
  }

  componentWillUnmount() {
    HotelStore.removeListener(HotelStore.eventTypes.HOTEL_CREATED,
      this.handleAddHotelResponse);
  }

  handleAddHotelResponse(data) {

    this.setState({errors: {}});//clear errors
    let errors = FormHelpers.extractFormErrorsFromData(data, this.state.errors);

    if (!data.success) {
      errors['message'] = {
        message: data.message,
        displayed: false,
      };
      this.setState({
        errors: errors,
      });
    } else {
      ShowMessage.success(data.message);
      this.setState({
        hotel: {
          name: '',
          description: '',
          image: '',
          numberOfRooms: ''
        }
      });
      this.props.history.push('/hotels/add');

    }

  }

  handleFormChange(event) {
    FormHelpers.handleFormChange.bind(this)(event, 'hotel');
  }

  handleAddHotel(event) {
    event.preventDefault();
    if (!this.validateUserData()) {
      return;
    }
    this.setState({errors: {}});//if form validation passed.. clear errors if any
    HotelAction.create(this.state.hotel);
  }

  validateUserData() {
    const hotel = this.state.hotel;
    let isFormValid = true;
    let errors = {};
    // validate name
    let isNameValid = validate.name(hotel.name,3);
    if (isNameValid !== true) {
      isFormValid = false;
      errors['name'] = {
        message: isNameValid,
        displayed: false,
      };
    }

    let isDescriptionValid = validate.description(hotel.description,10);
    if (isDescriptionValid !== true) {
      isFormValid = false;
      errors['description'] = {
        message: isDescriptionValid,
        displayed: false,
      };
    }

    if (parseInt(hotel.numberOfRooms,10) < 1) {
      isFormValid = false;
      errors['numberOfRooms'] = {
        message: "Number of rooms have to be a positive number.",
        displayed: false,
      };
    }
    if (hotel.image === '') {
      isFormValid = false;
      errors['image'] = {
        message: "Image cannot be empty.",
        displayed: false,
      };
    }
    if (Object.keys(errors).length > 0) {
      errors['formError'] = {
        message: 'Check the form for errors.',
        displayed: false,
      };
      this.setState({
        errors,
      });
    }

    return isFormValid;
  }

  render() {
    let errors = this.state.errors || {};

    // get errors for all inputs
    let nameErr = FormHelpers.getElementError(errors, 'name');
    let descriptionErr = FormHelpers.getElementError(errors, 'description');
    let imageErr = FormHelpers.getElementError(errors, 'image');
    let numberOfRoomsErr = FormHelpers.getElementError(errors,'numberOfRooms');

    // prepare to display all other errors
    let errorMessagesLeft = Object.keys(errors).map(key => {
      if (errors[key].displayed === false) {
        return (<div key={key} className=''>{errors[key].message}</div>);
      }
      return '';
    }).filter(e => e !== '');

    return (
      <section className="row">
        <Form
          //data
          formErrorBoxClass="text-danger well"
          // callbacks
          onChange={this.handleFormChange.bind(this)}
          onSubmit={this.handleAddHotel.bind(this)}
          // errors
          errors={errorMessagesLeft}
          //form style config
          formClass="
        col-md-6 col-md-offset-3
        col-sm-8 col-sm-offset-2
        col-xs-10 col-xs-offset-1
        well flipInX animated"

          formLegend="Add new Hotel."
        >
          <FormInputElement
            //input hotel name
            //data
            error={nameErr}
            type='name'
            name='name'
            placeholder='Hotel Name'
            value={this.state.hotel.name}
            onChange={this.handleFormChange.bind(this)}
            //styles
            formGroupClass={nameErr ? 'has-error' : ''}
            formItemLabelClass='col-md-4'
            formElementContainerClass='col-md-8'
            elementErrorClass='text-danger formFieldErrorText well well-sm'
          />
          <FromTextAreaComponent
            //input hotel Description
            //data
            error={descriptionErr}
            rows='5'
            name='description'
            placeholder='Hotel Description'
            value={this.state.hotel.description}
            onChange={this.handleFormChange.bind(this)}
            //styles
            formGroupClass={descriptionErr ? 'has-error' : ''}
            formItemLabelClass='col-md-4'
            formElementContainerClass='col-md-8'
            elementErrorClass='text-danger formFieldErrorText well well-sm'
          />
          <FormInputElement
            //TODO: change to ImageLink
            //data
            error={imageErr}
            type='url'
            name='image'
            placeholder='Image Link'
            value={this.state.hotel.image}
            onChange={this.handleFormChange.bind(this)}
            //styles
            formGroupClass={imageErr ? 'has-error' : ''}
            formItemLabelClass='col-md-4'
            formElementContainerClass='col-md-8'
            elementErrorClass='text-danger formFieldErrorText well well-sm'
          />
          <FormInputElement
            //TODO: change to NumberOfRooms
            //data
            error={numberOfRoomsErr}
            type='number'
            name='numberOfRooms'
            placeholder='Room Number'
            value={this.state.hotel.numberOfRooms}
            onChange={this.handleFormChange.bind(this)}
            //styles
            formGroupClass={numberOfRoomsErr ? 'has-error' : ''}
            formItemLabelClass='col-md-4'
            formElementContainerClass='col-md-8'
            elementErrorClass='text-danger formFieldErrorText well well-sm'
          />

          <div className="form-group">
            <FormButtonSubmit
              containerClass="col-md-8 col-md-offset-4"
              className='btn-success'
              text="Add hotel"
            />
          </div>
        </Form>
      </section>
    );
  }
}