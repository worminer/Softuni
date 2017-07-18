import React,{Component} from 'react';
//forms
import Form from '../common/forms/Form';
import FormHelpers from '../common/forms/FormHelpers';
import FormInputElement from '../common/forms/FormInputElement';
import FormButtonSubmit from '../common/forms/FormButtonSubmit';
//stores and actions
import CarAction from '../../actions/CarActions';
import CarStore from '../../stores/CarStore';
//validation
import validate from  '../../utill/validate';
//display messages
import ShowMessage from '../common/ShowPopupMessage';

export default class AddCarPage extends Component {
  constructor(props) {
    super(props);

    this.state = {
      car: {
        make: '',
        model: '',
        year: '',
        engine: '',
        price: '',
        image: '',
        mileage: ''
      },
      errors: {},
    };
    this.handleAddCarResponse = this.handleAddCarResponse.bind(this);
    CarStore.on(CarStore.eventTypes.CAR_CREATED,this.handleAddCarResponse);
  }

  componentWillUnmount() {
    CarStore.removeListener(CarStore.eventTypes.CAR_CREATED, this.handleAddCarResponse);
  }

  handleAddCarResponse(data) {
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
        car: {
          make: '',
          model: '',
          year: '',
          engine: '',
          price: '',
          image: '',
          mileage: ''
        }
      });
      this.props.history.push('/cars/create');

    }

  }

  handleFormChange(event) {
    FormHelpers.handleFormChange.bind(this)(event, 'car');
  }

  handleAddCar(event) {
    event.preventDefault();
    if (!this.validateUserData()) {
      return;
    }
    this.setState({errors: {}});//if form validation passed.. clear errors if any
    CarAction.create(this.state.car);
  }

  validateUserData() {
    const carState = this.state.car;
    let isFormValid = true;
    let errors = {};
    // validate name
    //make:"Make must be more than 3 symbols."
    let isMakeValid = validate.carMake(carState.make,3);
    if (isMakeValid !== true) {
      isFormValid = false;
      errors['make'] = {
        message: isMakeValid,
        displayed: false
      };
    }
    //model:"Model must be more than 3 symbols."
    let isModelValid = validate.carModel(carState.model,3);
    if (isModelValid !== true) {
      isFormValid = false;
      errors['model'] = {
        message: isModelValid,
        displayed: false
      };
    }
    // engine:"Engine must be more than 1 symbol."
    let isEngineValid = validate.carEngine(carState.engine,1);
    if (isEngineValid !== true) {
      isFormValid = false;
      errors['engine'] = {
        message: isEngineValid,
        displayed: false
      };
    }
    //price:"Price must be a positive number."
    if (carState.price < 1) {
      isFormValid = false;
      errors['price'] = {
        message: "Price must be a positive number.(client side)",
        displayed: false
      };
    }

    //year:"Year must be between 1950 and 2050."
    if (carState.year < 1950 || carState.year > 2050) {
      isFormValid = false;
      errors['year'] = {
        message: "Year must be between 1950 and 2050.(client side)",
        displayed: false
      };
    }
    //image:Image URL is required.
    if (carState.image === '') {
      isFormValid = false;
      errors['image'] = {
        message: "Image URL is required.(client side)",
        displayed: false
      };
    }

    if (Object.keys(errors).length > 0) {
      errors['formError'] = {
        message: 'Check the form for errors.(client side)',
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
    let makeErr   = FormHelpers.getElementError(errors, 'make');
    let modelErr  = FormHelpers.getElementError(errors, 'model');
    let yearErr   = FormHelpers.getElementError(errors, 'year');
    let engineErr = FormHelpers.getElementError(errors, 'engine');
    let priceErr  = FormHelpers.getElementError(errors, 'price');
    let imageErr  = FormHelpers.getElementError(errors, 'image');
    let mileageErr  = FormHelpers.getElementError(errors, 'mileage');
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
          onSubmit={this.handleAddCar.bind(this)}
          // errors
          errors={errorMessagesLeft}
          //form style config
          formClass="
        col-md-6 col-md-offset-3
        col-sm-8 col-sm-offset-2
        col-xs-10 col-xs-offset-1
        well flipInX animated"

          formLegend="Add new car."
        >
          <FormInputElement
            //input car make
            //data
            error={makeErr}
            type='text'
            name='make'
            placeholder='Car Make'
            value={this.state.car.make}
            onChange={this.handleFormChange.bind(this)}
            //styles
            formGroupClass={makeErr ? 'has-error' : ''}
            formItemLabelClass='col-md-4'
            formElementContainerClass='col-md-8'
            elementErrorClass='text-danger formFieldErrorText well well-sm'
          />
          <FormInputElement
            //input car make
            //data
            error={modelErr}
            type='text'
            name='model'
            placeholder='Car model'
            value={this.state.car.model}
            onChange={this.handleFormChange.bind(this)}
            //styles
            formGroupClass={modelErr ? 'has-error' : ''}
            formItemLabelClass='col-md-4'
            formElementContainerClass='col-md-8'
            elementErrorClass='text-danger formFieldErrorText well well-sm'
          />

          <FormInputElement
            // input for car year
            //data
            error={yearErr}
            type='number'
            name='year'
            placeholder='Car Year'
            value={this.state.car.year}
            onChange={this.handleFormChange.bind(this)}
            //styles
            formGroupClass={yearErr ? 'has-error' : ''}
            formItemLabelClass='col-md-4'
            formElementContainerClass='col-md-8'
            elementErrorClass='text-danger formFieldErrorText well well-sm'
          />

          <FormInputElement
            //input Car engine
            //data
            error={engineErr}
            type='text'
            name='engine'
            placeholder='Car engine'
            value={this.state.car.engine}
            onChange={this.handleFormChange.bind(this)}
            //styles
            formGroupClass={engineErr ? 'has-error' : ''}
            formItemLabelClass='col-md-4'
            formElementContainerClass='col-md-8'
            elementErrorClass='text-danger formFieldErrorText well well-sm'
          />

          <FormInputElement
            // input for car year
            // this might be of type date ?
            //data
            error={priceErr}
            type='number'
            name='price'
            placeholder='Car Price'
            value={this.state.car.price}
            onChange={this.handleFormChange.bind(this)}
            //styles
            formGroupClass={priceErr ? 'has-error' : ''}
            formItemLabelClass='col-md-4'
            formElementContainerClass='col-md-8'
            elementErrorClass='text-danger formFieldErrorText well well-sm'
          />

          <FormInputElement
            //input for ImageLink
            //data
            error={imageErr}
            type='url'
            name='image'
            placeholder='Image Link'
            value={this.state.car.image}
            onChange={this.handleFormChange.bind(this)}
            //styles
            formGroupClass={imageErr ? 'has-error' : ''}
            formItemLabelClass='col-md-4'
            formElementContainerClass='col-md-8'
            elementErrorClass='text-danger formFieldErrorText well well-sm'
          />

          <FormInputElement
          //input Car engine
          //data
          error={mileageErr}
          type='number'
          name='mileage'
          placeholder='Car mileage'
          value={this.state.car.mileage}
          onChange={this.handleFormChange.bind(this)}
          //styles
          formGroupClass={mileageErr ? 'has-error' : ''}
          formItemLabelClass='col-md-4'
          formElementContainerClass='col-md-8'
          elementErrorClass='text-danger formFieldErrorText well well-sm'
        />

          <div className="form-group">
            <FormButtonSubmit
              containerClass="col-md-8 col-md-offset-4"
              className='btn-success'
              text="Add Car"
            />
          </div>
        </Form>
      </section>
    );
  }
}