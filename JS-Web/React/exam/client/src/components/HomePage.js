import React,{Component} from 'react';

import HomeAction from '../actions/HomeActions';
import HomeStore from '../stores/HomeStore';

export default class HomePage extends Component{
  constructor(props) {
    super(props);
    this.state = {
      cars: '',
      users: ''
    };
    this.handleGetStatsResponse = this.handleGetStatsResponse.bind(this);
    HomeStore.on(HomeStore.eventTypes.CAR_CREATED,this.handleGetStatsResponse);
  }

  componentWillUnmount() {
    HomeStore.removeListener(HomeStore.eventTypes.CAR_CREATED, this.handleGetStatsResponse);
  }

  handleGetStatsResponse(data) {
      this.setState({
        cars: data.cars,
        users: data.users
      });
  }
  
  componentDidMount() {
    HomeAction.getStats();
  }

  render () {
    return (
      <section className="row well" ref='root'>
        <div className="col-md-4 col-md-offset-4 text-center">
          <h1>Site statics</h1>
          <table className="table table-striped table-hover ">
            <tbody>
            <tr>
              <th>Site users:</th>
              <td>{this.state.users}</td>
            </tr>
            <tr>
              <th>Site cars:</th>
              <td>{this.state.cars}</td>
            </tr>
            </tbody>
          </table>
        </div>

      </section>
    )
  }
}
