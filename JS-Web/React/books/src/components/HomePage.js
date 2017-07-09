import React,{Component} from 'react';
import {Link} from 'react-router-dom';


import BooksStore from '../stores/BooksStore';
import BooksActions from '../actions/BooksActions';


export default class HomePage extends Component{
  constructor(props) {
    super(props);

    this.state = BooksStore.getState();
    this.onChange = this.onChange.bind(this);
  }

  onChange(state) {
    //to prevent setState() before component mount
    if (this.refs.root) {
      this.setState(state);
    }
  }
  
  componentDidMount() {
    BooksStore.listen(this.onChange);
    BooksActions.getLastBooks(10);
  }
  
  componentWillUnMount() {
    BooksStore.unlisten(this.onChange)
  }

  render () {

    let books = this.state.lastBooks.map(book => (
      <tr key={book._id}>
        <td>{book.title}</td>
        <td>{book.author.name}</td>
        <td>{book.createdAt}</td>
        <td><Link to={`/book/${book._id}`} >Read More</Link></td>
      </tr>
    ));

    return (
      <section className="row" ref='root'>
        <table className="table table-striped table-hover">
          <thead>
          <tr>
            <th>Title</th>
            <th>Author</th>
            <th>date added</th>
            <th>Click to read more</th>
          </tr>
          </thead>
          <tbody>
          {books}
          </tbody>
        </table>
      </section>
    )
  }
}
