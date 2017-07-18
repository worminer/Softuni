import React,{Component} from 'react'
import {Link} from 'react-router-dom';

//stores and actions
import HotelAction from '../actions/HotelActions';
import HotelStore from '../stores/HotelStore';

export default class HomePage extends Component{

  constructor(props) {
    super(props);

    this.state = {
      hotels: [],
      errors: {},
      page: parseInt(this.props.match.params.page, 10) || 1
    };
    this.handleHotelsPageResponse = this.handleHotelsPageResponse.bind(this);
    HotelStore.on(HotelStore.eventTypes.HOTELS_FETCHED,this.handleHotelsPageResponse);
  }

  componentWillUnmount() {
    HotelStore.removeListener(HotelStore.eventTypes.HOTELS_FETCHED,
      this.handleHotelsPageResponse);
  }

  componentDidMount() {
    HotelAction.listPage(this.state.page);
  }

  handleHotelsPageResponse(data) {
    this.setState({
      hotels: data
    })
  }

  goToNextPage () {
    if (this.state.hotels.length < 10) {
      return
    }
    let page = this.state.page + 1;
    this.setState({
      page : page
    });

    this.props.history.push(`/${page}`);

  }

  goToPrevPage () {
    if (this.state.page === 1) {
      return
    }
    let page = this.state.page - 1;

    this.setState({
      page: page
    });

    this.props.history.push(`/${page}`);

  }
  componentWillReceiveProps(props) {
    HotelAction.listPage(parseInt(props.match.params.page, 10) || 1);
  }

  render() {
    let hotelsInfo = this.state.hotels.map((hotel,index) => {
      return (
        <div className="well" key={hotel.id}>
          <div className="hotel-homepage-container" >
            <div className="col-md-4 ">
              <Link to={`/hotel/details/${hotel.id}`}>
                <img className="hotel-homepage-image" src={hotel.image} alt={hotel.name + ' no image'} />
              </Link>
            </div>
            <div className="col-md-7 col-md-offset-1">
              <table className="table table-striped table-hover ">
              <tbody>
                <tr>
                  <th>Hotel Name</th>
                  <td><Link to={`/hotel/details/${hotel.id}`}>{hotel.name}</Link></td>
                </tr>
                <tr>
                  <th>Number of rooms</th>
                  <td>{hotel.numberOfRooms}</td>
                </tr>
                <tr>
                  <th>Added On</th>
                  <td>{hotel.createdOn}</td>
                </tr>
                <tr>
                  <th>ID</th>
                  <td>{hotel.id}</td>
                </tr>
              </tbody>
              </table>
            </div>
          </div>
        </div>
      )
    });
    return (
      <section className="row">
        {hotelsInfo}
        <div className="col-md-12 text-center well">
          <button onClick={this.goToPrevPage.bind(this)}>Prev</button>
          <button onClick={this.goToNextPage.bind(this)}>Next</button>
        </div>
      </section>

    );
  }
}
