import React from 'react';
import PropTypes from 'prop-types';
import superagent from 'superagent';
import Component from '../component';
import Pagination from '../pagination';
import Loading from '../loading';

class Table extends Component {
    constructor(props) {
        super(props);
        this.state = {
            page   : parseInt(this.getParams('page', 1), 0),
            data   : props.dataSource,
            total  : 0,
            loading: true
        };
        this.pageChange = this.pageChange.bind(this);
        this.loading = null;
    }

    componentDidMount() {
        const { dataSource } = this.props;
        if (typeof dataSource === 'string') {
            this.queryData();
        }
    }

    pageChange(page) {
        this.setState({ 'page': page, loading: true }, () => {
            this.queryData();
        });
    }

    queryData() {
        const { page } = this.state;
        const { dataSource, size } = this.props;
        new Promise((resolve, reject) => {
            superagent.get(dataSource)
                .query({ page, size })
                .end((err, res) => {
                    if (typeof res !== 'undefined' && res.ok) {
                        resolve(JSON.parse(res.text));
                    } else {
                        reject(err);
                    }
                });
        }).then((data) => {
            if (data.status) {
                this.setState({ data: data.list, total: data.count, loading: false });
            }
        }).catch((err)=>{
            console.log(err);
            this.setState({ 'loading': false });
        });
    }

    reload() {
        this.queryData();
    }

    render() {
        const { column, size } = this.props;
        const { data, total, page, loading } = this.state;
        if (loading) {
            return (<Loading/>);
        }
        return (
            <div>
                <div className={this.classNames('data-table')}>
                    <table>
                        <thead>
                            <tr>
                                {Object.keys(column).map((key, i) => (<th key={`th-${ i }`}>{key}</th>))}
                            </tr>
                        </thead>
                        <tbody>
                            {typeof data === 'object' && data.map((v, i) => (
                                <tr key={`tr-${ i }`}>
                                    {Object.values(column).map((key, ii) => (<td key={`tr-${ i }-td-${ ii }`}>{typeof key === 'function' ? key(v) : v[key]}</td>))}
                                </tr>
                            ))}
                        </tbody>
                    </table>
                    <div className="data-info">
                            总共{total}条记录
                    </div>
                </div>
                <Pagination total={total} currentPage={page} size={size} onChange={this.pageChange}/>
            </div>
        );
        

    }
}

Table.propTypes = {// 属性校验器，表示改属性必须是bool，否则报错
    dataSource: PropTypes.any.isRequired,
    column    : PropTypes.object.isRequired,
    size      : PropTypes.number
};
Table.defaultProps = {
    size: 10
};// 设置默认属性

// 导出组件
export default Table;