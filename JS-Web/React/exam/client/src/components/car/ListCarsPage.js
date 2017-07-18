import React,{Component} from 'react'
import {Link} from 'react-router-dom';

//stores and actions
import CarAction from '../../actions/CarActions';
import CarStore from '../../stores/CarStore';
import Form from '../common/forms/Form';
import FormInputElement from '../common/forms/FormInputElement';
import FormButtonSubmit from '../common/forms/FormButtonSubmit';
import FormHelpers from '../common/forms/FormHelpers';

export default class ListCarsPage extends Component{

  constructor(props) {
    super(props);

    this.state = {
      cars: [],
      errors: {},
      page: parseInt(this.props.match.params.page, 10) || 1,
      search: {
        query: this.props.match.params.search || '',
        errors: {}
      }

    };
    this.handleListCarsResponse = this.handleListCarsResponse.bind(this);
    CarStore.on(CarStore.eventTypes.CARS_FETCHED,this.handleListCarsResponse);
  }

  componentWillUnmount() {
    CarStore.removeListener(CarStore.eventTypes.CARS_FETCHED,
      this.handleListCarsResponse);
  }

  componentDidMount() {
    CarAction.listPage(this.state.page);
  }

  handleListCarsResponse(data) {
    // i receive comments here and not in the details page ?
    this.setState({
      cars: data
    })
  }

  goToNextPage () {
    if (this.state.cars.length < 10) {
      return
    }
    let page = this.state.page + 1;
    this.setState({
      page : page
    });

    this.props.history.push(`/cars/all/${page}/${this.state.search.query}`);

  }

  goToPrevPage () {
    if (this.state.page === 1) {
      return
    }
    let page = this.state.page - 1;

    this.setState({
      page: page
    });

    this.props.history.push(`/cars/all/${page}/${this.state.search.query}`);
  }

  handleFormChange(event) {
    FormHelpers.handleFormChange.bind(this)(event, 'search');
  }
  handleSearchCar(event){
    event.preventDefault();
    if (!this.validateForm()) {
      return;
    }
    this.props.history.push(`/cars/all/${this.state.page}/${this.state.search.query}`);
  }
  validateForm () {
    // quick validate
    let isFormValid = true;
    let searchState= this.state.search;
    if (!this.state.search.query || this.state.search.query === '') {
      searchState['errors']['query'] = {
        message: 'Search query cannot be empty!',
        displayed: false
      };
      isFormValid = false;
    }
    else if (this.state.search.query.length < 3) {
      searchState['errors']['query'] = {
        message: 'Search query cannot be less then 3 symbols!',
        displayed: false
      };
      isFormValid = false;
    }
    else {
      searchState['errors'] = {}
    }

    this.setState({search: searchState });
    return isFormValid;
  }

  componentWillReceiveProps(props) {
    CarAction.listPage(parseInt(props.match.params.page, 10) || 1,this.state.search.query);
  }

  render() {
    let CarsInfo = this.state.cars.map((car, index) => {
      return (
        <div className="" key={car.id}>
          <div className="car-list-container" >
            <div className="col-md-4 ">
              <Link to={`/car/details/${car.id}`}>
                <img className="car-list-image" src={car.image} alt={car.make + ' no image'} />
              </Link>
            </div>
            <div className="col-md-7 col-md-offset-1">
              <table className="table table-striped table-hover ">
              <tbody>
                <tr>
                  <th>Car Make: </th>
                  <td><Link to={`/car/details/${car.id}`}>{car.make}</Link></td>
                </tr>
                <tr>
                  <th>Car Model: </th>
                  <td>{car.model}</td>
                </tr>
                <tr>
                  <th>Car price: </th>
                  <td>${car.price}</td>
                </tr>
                <tr>
                  <th>Car reviews/Likes: </th>
                  <td>{car.reviews.length}/{car.likes.length}</td>
                </tr>
                <tr>
                  <th>Added By : </th>
                  <td>{car.createdBy}</td>
                </tr>
                <tr>
                  <th>Car ID: </th>
                  <td>{car.id}</td>
                </tr>

              </tbody>
              </table>
            </div>
          </div>
          <hr/>
        </div>
      )
    });
    // handle errors
    let searchErrors = this.state.search.errors || {};

    // get errors for all inputs
    let searchError   = FormHelpers.getElementError(searchErrors, 'query');

    // prepare to display all other errors
    let errorMessagesLeft = Object.keys(searchErrors).map(key => {
      if (searchErrors[key].displayed === false) {
        return (<div key={key} className=''>{searchErrors[key].message}</div>);
      }
      return '';
    }).filter(e => e !== '');

    return (
      <section className="row">
        <div>
          <Form
            //data
            formErrorBoxClass="text-danger well"
            // callbacks
            onChange={this.handleFormChange.bind(this)}
            onSubmit={this.handleSearchCar.bind(this)}
            // errors
            errors={errorMessagesLeft}
            //form style config
            formClass="
        col-md-6 col-md-offset-3
        col-sm-8 col-sm-offset-2
        col-xs-10 col-xs-offset-1
        well flipInX animated"

            formLegend="Search"
          >
            <FormInputElement
              //input car make
              //data
              error={searchError}
              type='text'
              name='query'
              placeholder='Search Car'
              value={this.state.search.query}
              onChange={this.handleFormChange.bind(this)}
              //styles
              formGroupClass={searchError ? 'has-error' : ''}
              formItemLabelClass='col-md-4'
              formElementContainerClass='col-md-8'
              elementErrorClass='text-danger formFieldErrorText well well-sm'
            />

            <div className="form-group">
              <FormButtonSubmit
                containerClass="col-md-8 col-md-offset-4"
                className='btn-success'
                text="Search"
              />
            </div>
          </Form>
        </div>
        {CarsInfo}
        <div className="col-md-12 text-center well">
          <button onClick={this.goToPrevPage.bind(this)}>Prev</button>
          <button onClick={this.goToNextPage.bind(this)}>Next</button>
        </div>
      </section>

    );
  }
}
