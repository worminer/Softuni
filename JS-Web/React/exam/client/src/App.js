import React, { Component } from 'react';

import Header from './components/common/Header';
import Main from './components/common/Main';
import Footer from './components/common/Footer'
// emulate normal semantic html

class App extends Component {
  render() {
    return (
      <div>
        <Header />
        <Main />
        <Footer />
      </div>
    );
  }
}

export default App;
