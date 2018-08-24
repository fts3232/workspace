import React from 'react';
import { Link } from 'react-router-dom';
import Component from '../../../components/component';
import Table from '../../../components/table';
import Pagination from '../../../components/pagination';
import Breadcrumb from '../../../components/breadcrumb';
import Panel from '../../../components/panel';
import Button from '../../../components/button';

class Main extends Component {
    constructor(props) {
        super(props);
        this.state = {};
    }

    render() {
        const data = [
            { 'id': 1, 'date': '2018-09-20', 'type': '收入', 'amount': '200', 'description': '工资' },
            { 'id': 2, 'date': '2018-09-20', 'type': '收入', 'amount': '200', 'description': '工资' },
            { 'id': 3, 'date': '2018-09-20', 'type': '收入', 'amount': '200', 'description': '工资' }
        ];
        const colunm = {
            'ID': 'id',
            '日期': 'date',
            '类型': 'type',
            '金额': 'amount',
            '描述': 'description'
        };
        const total = 500;
        const breadcrumb = [{ 'name': '账簿', 'path': '/cash-book' }];
        const currentPage = parseInt(this.getParams('page', 1), 0);
        return (
            <div>
                <Breadcrumb data={breadcrumb}/>
                <Panel>
                    <div className="margin-bottom-10">
                        <Link to="/cash-book/add">
                            <Button type="button" category="info">添加</Button>
                        </Link>
                    </div>
                    <Table data={data} colunm={colunm} total={total}/>
                    <Pagination total={total} currentPage={currentPage}/>
                </Panel>
            </div>
        );
    }
}

Main.propTypes = {};

Main.defaultProps = {};

// 导出组件
export default Main;