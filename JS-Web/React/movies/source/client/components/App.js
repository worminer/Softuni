import React, {Component} from 'react';

import UserStore from '../stores/UserStore';

import Navbar from "./Navbar";
import Footer from './Footer';

export default class App extends Component {
  constructor(props) {
    super(props);
    this.state = UserStore.getState();

    this.onChange = this.onChange.bind(this);
  }

  onChange (state) {
    this.setState(state)
  }

  componentDidMount() {
    UserStore.listen(this.onChange);
    UserStore.loginUser();
  }

  componentWillUnMount() {
    UserStore.unlisten(this.onChange);
  }

  render() {

    return (
        <div>
            <Navbar />
            { this.props.children }
            <Footer/>
        </div>
    );
  }
}