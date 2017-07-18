import React,{Component} from 'react'
import {Link} from 'react-router-dom';

//stores and actions
import CarAction from '../../actions/CarActions';
import CarStore from '../../stores/CarStore';
import FormButtonSubmit from '../common/forms/FormButtonSubmit';
import ShowMessage from '../common/ShowPopupMessage';

export default class ListCarsPage extends Component{

  constructor(props) {
    super(props);

    this.state = {
      cars: [],
      errors: {},
    };
    this.handleMyCarsResponse = this.handleMyCarsResponse.bind(this);
    CarStore.on(CarStore.eventTypes.MY_CARS_FETCHED,this.handleMyCarsResponse);
    this.handleMyCarDeletedResponse = this.handleMyCarDeletedResponse.bind(this);
    CarStore.on(CarStore.eventTypes.MY_CAR_DELETED,this.handleMyCarDeletedResponse);
  }

  componentWillUnmount() {
    CarStore.removeListener(CarStore.eventTypes.CARS_FETCHED,
      this.handleMyCarsResponse);
    CarStore.removeListener(CarStore.eventTypes.MY_CAR_DELETED,
      this.handleMyCarDeletedResponse);
  }

  componentDidMount() {
    CarAction.getMyCars();
  }

  handleMyCarsResponse(data) {
    this.setState({
      cars: data
    })
  }
  handleMyCarDeletedResponse(data){
    if (data.success) {
      ShowMessage.success(data.message)
      CarAction.getMyCars();
    }
    else {
      ShowMessage.error(data.message)
    }

  }

  handleDeleteThisCar(event){
    event.preventDefault();
    CarAction.deleteCar(event.target.id);
  }
  render() {
    let CarsInfo = (
      <div className="well text-center">
        <h1>You don't have any cars!</h1>
      </div>
    );

    if (this.state.cars.length > 0) {
      CarsInfo = this.state.cars.map((car, index) => {
        return (
          <div className="well" key={car.id}>
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
                    <th>Car ID: </th>
                    <td>{car.id}:</td>
                  </tr>
                  </tbody>
                </table>
                <FormButtonSubmit
                  onClick={this.handleDeleteThisCar.bind(this)}
                  id={car.id}
                  containerClass="col-md-8 col-md-offset-4"
                  className='btn-danger btn-xs'
                  text="Delete this Car"
                />
              </div>
            </div>
          </div>
        )
      });
    }

    return (
      <section className="row">
        {CarsInfo}
      </section>

    );
  }
}
