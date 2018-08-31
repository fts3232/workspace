import React from 'react';
import { Link } from 'react-router-dom';
import img from './images/404-error.png';
import Component from '../../../components/component';

class NotFound extends Component {
    render() {
        return (
            <div className="not-found">
                <img src={img} alt="404"/>
                <h2>PAGE NOT FOUND</h2>
                <h3>WE COULDN’T FIND THIS PAGE</h3>
                <Link to="/" className="back">Back To Home</Link>
            </div>
        );
    }

}

NotFound.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
};
NotFound.defaultProps = {};// 设置默认属性

// 导出组件
export default NotFound;