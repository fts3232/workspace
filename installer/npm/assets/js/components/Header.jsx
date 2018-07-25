import React from 'react';
import PropTypes from 'prop-types';
import { Link } from 'react-router-dom';

class Header extends React.Component {
    constructor(props){
        super(props);
    }
    render() {
        return (
            <div>
                <div>
                    <Link  to="/Counter">Counter</Link>
                </div>
                <div>
                    <Link  to="/Todo">Todo</Link>
                </div>
            </div>
        );
    }
}

Header.propTypes={//属性校验器，表示改属性必须是bool，否则报错

}
Header.defaultProps={

};//设置默认属性

export default Header;