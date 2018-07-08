import React from 'react';
import axios from "../../../../node_modules/.0.18.0@axios";

class Child extends React.Component {

    constructor(props) {
        super(props);
        this.state = {
            name:''
        }
    }
    fetch(){
        let _this = this;
        axios.get('http://localhost:3001/name')
            .then(function (response) {
                _this.setState({name:response.data})
                //console.log(response);
            })
            .catch(function (error) {
                console.log(error);
            });
    }
    componentDidMount(){
        console.log(this.state.name)
        if(!this.state.name){
            this.fetch();
        }
    }

    render() {
        return (
            <div>
                <h3>ID: {this.state.name}</h3>
            </div>
        );
    }
}

export default Child;