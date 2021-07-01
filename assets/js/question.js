import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import Next from "./FunctionClick";
import '../styles/app.css';
import 'bootstrap/dist/css/bootstrap.min.css';
import { Button, ProgressBar } from "react-bootstrap";
import 'bootstrap';

export class Question extends Component {
    constructor(props)
    {

     super(props);
     
     
     
     this.state = {

        Currentindex : 0,
        error:null, 
        isLoaded: false,
        allQuestion : [],
        bquestion : null,
        answer : [],
        correct : null,
        score : 0,
        endGame : false,
        disabled : true
         
     };
  
    };
   
   
    nextQuestion()
     {
        const{Currentindex}= this.state;
        console.log("HAHAAA MIAAAW");
        console.log("MIAW2");
        let newCurrentindex = Currentindex+1;
        this.setState({
        Currentindex: newCurrentindex,
      });
     }
   
    
   
    loadquestion = () => 
      {
        const{Currentindex} = this.state;
        fetch("http://127.0.0.1:8000/api/question/")
        .then(res => res.json())
        .then(
          (result) => { 
            this.setState(() =>  {
            return {
              isLoaded: true,
              bquestion: result[Currentindex].titles,
              answer : result[Currentindex].Choix,
              correct : result[Currentindex].Reponse,
              allQuestion : result,
              
             }  
                
            });
            },
          // Remarque : il est important de traiter les erreurs ici
          // au lieu d'utiliser un bloc catch(), pour ne pas passer à la trappe
          // des exceptions provenant de réels bugs du composant.
          (error) => {
            this.setState({
              isLoaded: true,
              error
            });
          }
        )
      };


      componentDidMount() {
        this.loadquestion();
     }
      
      

      vote = index =>
      {
         console.log("MIAW1");
         const [answer,correct] = this.state;
         const answeretud = answer[index];
         if(answeretud==correct)
         {
         this.setState({
          score : this.state.score+1,
        })
        };
      };

      componentDidUpdate(PrevProps,prevState)
      {
        const{Currentindex} = this.state;
        if (Currentindex !== prevState.Currentindex) {
          this.loadquestion();
        }
      };
   
      helloThere(){
        alert('Hi! Admin');
      }
      messageInConsole() {
        console.log("It's working")
      }
    
  
      
    

    

    
    
    render() {
        const {error,isLoaded,bquestion,Currentindex,answer,correct,allQuestion,disabled} = this.state;
        
           
            return (
            <div className="content">
                
                <div className="title">Question</div>
                
                { 
              
                <div className="titleofquestion">
                
               
                {bquestion}
                {correct}
                
                </div>
                }
                {answer.map((value,index) =>
                  <Button className="choixdequest">
                    {index+1} : {value}
                  </Button>
                  )
                }
                
                {
                <div>
                <Button 
                onClick={()=>console.log("ABC")}
                >
                        SuivantABC {this.state.Currentindex}
                </ Button>
                
               </div> 
               }
               
                
                
                
                
                  
            </div>
            );
            
        
    }
}


export default Question;