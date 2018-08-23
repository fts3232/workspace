import React from 'react';
import { Link } from 'react-router-dom';
import PropTypes from 'prop-types';
import Component from '../../../components/component';
import style from './style/main.scss';

class NavBar extends Component {
    render() {
        const { router } = this.context;
        const { location } = router.route;
        const { data } = this.props;
        return (
            <div className={style['nav-bar']}>
                <ul>
                    {data.map((v, i) => {
                        let className = null;
                        if (location.pathname.toLowerCase() === v.path.toLowerCase() || location.pathname.toLowerCase().indexOf(v.path.toLowerCase()) !== -1) {
                            className = style.active;
                        }
                        return (
                            <li className={className} key={i}>
                                <Link to={v.path}>{v.name}</Link>
                            </li>
                        );
                    })}
                </ul>
            </div>
        );
    }
}

NavBar.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    data: PropTypes.array
};

NavBar.defaultProps = {
    data: {}
};// 设置默认属性

// 导出组件
export default NavBar;