import React,{Component} from 'react';
import PetActions from '../../actions/PetActions';
import PetStore from '../../stores/PetStore';
import {Link} from 'react-router-dom';

export default class ListPetsPage extends Component{
  constructor(props) {
    super(props);

    this.state = {
      pets:[],
      page: parseInt(this.props.match.params.page, 10) || 1
    };

    this.handlePetsFetchedResponse = this.handlePetsFetchedResponse.bind(this);
    PetStore.on(
      PetStore.eventTypes.PETS_FETCHED,
      this.handlePetsFetchedResponse
    )
  }
  
  componentWillUnmount() {
    PetStore.removeListener(
      PetStore.eventTypes.PETS_FETCHED,
      this.handlePetsFetchedResponse
    )
  }

  handlePetsFetchedResponse (data) {
    this.setState({
      pets: data
    });
  }
  componentWillMount() {
    PetActions.list(this.state.page)
  }

  goToNextPage () {
    if (this.state.pets.length < 10) {
      return
    }
    let page = this.state.page + 1;
    this.setState({
      page : page
    });

    this.props.history.push(`/pets/list/${page}`);
    
  }

  goToPrevPage () {
    if (this.state.page === 1) {
      return
    }
    let page = this.state.page - 1;

    this.setState({
      page: page
    });

    this.props.history.push(`/pets/list/${page}`);
   
  }

  componentWillReceiveProps(props) {
    PetActions.list(props.match.params.page);
  }
  
  render () {
    let pets = 'No pets in DB';
    pets = this.state.pets.map(pet => (
      <div key={pet.id} id={pet.id} className="col-md-6 well" style={{ padding: '5px'}}>
        <div className="col-md-6">
          <Link to={`/pet/details/${pet.id}`} >
            <img src={pet.image} style={{
              width:'100%',
              border: '1px solid black',
              boxSizing: 'border-box'
            }} alt=""/>

          </Link>
        </div>
        <div className="col-md-6">
          <table className="table table-striped table-hover">

            <tbody>
            <tr>
              <th>ID</th>
              <td>{pet.id}</td>
            </tr>
            <tr>
              <th>Name</th>
              <td>{pet.name}</td>
            </tr>
            <tr>
              <th>Type</th>
              <td>{pet.type}</td>
            </tr>
            <tr>
              <th>Breed</th>
              <td>{pet.breed}</td>
            </tr>
            <tr>
              <th>Age</th>
              <td>{pet.age}</td>
            </tr>

            </tbody>
          </table>
        </div>
      </div>

    ));
    return (
      <section className="row">
        <div>
          {pets}
        </div>
        <div className="col-md-12 text-center well">
          <button onClick={this.goToPrevPage.bind(this)}>Prev</button>
          <button onClick={this.goToNextPage.bind(this)}>Next</button>
        </div>
      </section>
        
    )
  }
}