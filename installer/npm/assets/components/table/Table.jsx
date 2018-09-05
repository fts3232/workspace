import React from 'react';
import PropTypes from 'prop-types';
import Component from '../component';

class Table extends Component {
    render() {
        const { data, colunm, total } = this.props;
        return (
            <div className={this.classNames('data-table')}>
                <table>
                    <thead>
                        <tr>
                            {Object.keys(colunm).map((key, i) => (<th key={i}>{key}</th>))}
                        </tr>
                    </thead>
                    <tbody>
                        {data.map((v, i) => (
                            <tr key={i}>
                                {Object.values(colunm).map((key, ii) => (<td key={ii}>{typeof key === 'function' ? key(v) : v[key]}</td>))}
                            </tr>
                        ))}
                    </tbody>
                </table>
                <div className="data-info">
                    总共{total}条记录
                </div>
            </div>
        );
    }
}

Table.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    data  : PropTypes.array.isRequired,
    colunm: PropTypes.object.isRequired,
    total : PropTypes.number.isRequired
};
Table.defaultProps = {};// 设置默认属性

// 导出组件
export default Table;