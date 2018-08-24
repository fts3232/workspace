import React from 'react';
import Component from '../../../components/component';
import style from './style/main.scss';
import Icon from '../../../components/icon';

class Header extends Component {
    render() {
        return (
            <div className={style.header}>
                <div className={style.left}>
                    <Icon name="menu"/>
                </div>
            </div>
        );
    }
}

Header.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错

};
Header.defaultProps = {};// 设置默认属性

// 导出组件
export default Header;