import React,{Component} from 'react';
import {Link} from 'react-router-dom';

import data from './../data/books';

const numberOfBooks = 6;

export default class HomePage extends Component{
  constructor(props) {
    super(props);

    this.state = {
      lastBooks : []
    }
  }

  componentDidMount() {
    data.getLastBooks(numberOfBooks).then( books => {
      this.setState({
        lastBooks : books
      });
    });

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
      <section className="row">
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
