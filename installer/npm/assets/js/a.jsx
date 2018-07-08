import React from 'react';
import PropTypes from 'prop-types';

class Aaa extends React.Component {
    constructor(props){
        super(props);
        this.state = {
            name:''
        }

    }
    getMenu(){
        return this.props.menu;
    }
    fetch(){
        let _this = this;
        axios.get('/name')
            .then(function (response) {
                _this.setState({name:response.data});
                //console.log(response);
            })
            .catch(function (error) {
                //console.log(error);
            });
    }
    componentDidMount(){
        this.fetch();
    }
    render() {
        let name = this.state.name;
        return (
            <div className="nav">
                <h2>Accounts</h2>
                <ul>
                    <li>
                        <Link to="/Counter">Counter</Link>
                    </li>
                    <li>
                        <Link to="/Todo">Todo</Link>
                    </li>
                </ul>
                <div>{name}</div>
                <img src={img} />
                {renderRoutes(this.props.route.routes)}
            </div>
        );
    }
}

App.propTypes={//属性校验器，表示改属性必须是bool，否则报错
    menu: PropTypes.array
}
App.defaultProps={
    menu:[],
    location:'',
    context:{}
};//设置默认属性

export default App;