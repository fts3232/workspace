import { Link } from 'react-router-dom';
import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';
import style from './style/main.scss';

class Breadcrumb extends Component {
    render() {
        const { data } = this.props;
        const { router } = this.context;
        const { location } = router.route;
        return (
            <ul className={style.breadcrumb}>
                {data.map((v, i) => (
                    <li className={location.pathname.toLowerCase() === v.path.toLowerCase() ? style.active : null} key={i}>
                        {location.pathname.toLowerCase() !== v.path.toLowerCase() ? (<Link to={v.path}>{v.name}</Link>) : v.name}
                    </li>
                ))}
            </ul>
        );
    }
}

Breadcrumb.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    data: PropTypes.array.isRequired
};
Breadcrumb.defaultProps = {};// 设置默认属性

// 导出组件
export default Breadcrumb;