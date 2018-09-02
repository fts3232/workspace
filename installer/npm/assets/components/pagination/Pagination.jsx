import { Link } from 'react-router-dom';
import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Pagination extends Component {
    constructor(props) {
        super(props);
        this.state = {
            currentPage: props.currentPage
        };
    }

    changePage(page) {
        const { onChange } = this.props;
        this.setState({
            currentPage: page
        }, ()=>{
            onChange(page);
        });
    }

    render() {
        const { total, size } = this.props;
        let { maxShowPage } = this.props;
        let { currentPage } = this.state;
        maxShowPage -= 1;
        const totalPage = Math.ceil(total / size);
        if (currentPage > totalPage) {
            currentPage = 1;
        }
        const li = [];
        let start = currentPage - 2 <= 0 ? 1 : currentPage - 2;
        const end = start + maxShowPage > totalPage ? totalPage : start + maxShowPage;
        if (end - start < maxShowPage) {
            start = end - maxShowPage <= 0 ? 1 : end - maxShowPage;
        }
        for (let i = start; i <= end; i++) {
            li.push(
                <li role="menuitem" className={i === currentPage ? 'active' : null} key={i}>
                    <Link to={`?page=${ i }`} onClick={()=>{ this.changePage(i); }}>{i}</Link>
                </li>
            );
        }
        return (
            <div className={this.classNames('pagination')}>
                <ul>
                    <li role="menuitem" className={currentPage === 1 ? 'disabled' : null} onClick={()=>{ const i = currentPage - 1;this.changePage(i); }}>
                        <Link to={`?page=${ currentPage - 1 }`}>上一页</Link>
                    </li>
                    {li}
                    <li role="menuitem" className={currentPage === totalPage ? 'disabled' : null} onClick={()=>{ const i = currentPage + 1; this.changePage(i); }}>
                        <Link to={`?page=${ currentPage + 1 }`}>下一页</Link>
                    </li>
                </ul>
            </div>
        );
    }
}

Pagination.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    total      : PropTypes.number.isRequired,
    size       : PropTypes.number,
    maxShowPage: PropTypes.number,
    currentPage: PropTypes.number.isRequired
};
Pagination.defaultProps = {
    size       : 10,
    maxShowPage: 5
};// 设置默认属性

// 导出组件
export default Pagination;