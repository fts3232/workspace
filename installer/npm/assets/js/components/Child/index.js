import React from 'react';
import axios from 'axios';

class Child extends React.Component {
    constructor (props) {
        super (props);
        this.state = {
            name: ''
        };
    }

    componentDidMount () {
        const { name } = this.state;
        if (!name) {
            this.fetch ();
        }
    }

    fetch () {
        axios
            .get ('http://localhost:8080/test.php')
            .then (response => {
                this.setState ({ name: response.data });
                // console.log(response);
            })
            .catch (error => {
                console.log (error);
            });
    }

    render () {
        const { name } = this.state;
        return (
            <div>
                <h3>



















ID:
                    {name}
                </h3>
            </div>
        );
    }
}

export default Child;
