import React,{Component} from 'react';
import Router from '../routes/Router';

export default class Main extends Component{
  render () {
    return (
    <main className="container">
      <Router />
    </main>
    )
  }
}