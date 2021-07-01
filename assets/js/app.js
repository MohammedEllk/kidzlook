import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import '../styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import 'bootstrap';
import Question from './question'
import Test from './test'
import $ from 'jquery';





class App extends Component {
    render() {
        return (
         <div>
         <Question>
          
         </Question>
         <Test/>
         </div>
         
        
        );
    }
}




ReactDOM.render(<App />, document.getElementById('root'));
