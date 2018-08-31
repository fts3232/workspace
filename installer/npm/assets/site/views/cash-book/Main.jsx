import React from 'react';
import { Link } from 'react-router-dom';
import superagent from 'superagent';
import Component from '../../../components/component';
import Table from '../../../components/table';
import Pagination from '../../../components/pagination';
import Breadcrumb from '../../../components/breadcrumb';
import Panel from '../../../components/panel';
import Button from '../../../components/button';
import { Col, Row } from '../../../components/grid';
import Message from '../../../components/message';

class Main extends Component {
    constructor(props) {
        super(props);
        this.state = {};
    }

    componentDidMount() {
        new Promise((resolve, reject) => {
            const url = 'http://localhost:8000/api/cashBook/get';
            const data = { page: 1 };
            superagent.get(url)
                .send(data)
                .end((err, res) => {
                    if (typeof res !== 'undefined' && res.ok) {
                        resolve(JSON.parse(res.text));
                    } else {
                        reject(err);
                    }
                });
        }).then((data) => {
            console.log(data);
        });
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
            <Row>
                <Message type="info" content="test"/>
                <Message type="info" content="test"/>
                <Message type="info" content="test"/>
                <Message type="info" content="test"/>

                <Col span={12}>
                    <Breadcrumb data={breadcrumb}/>
                </Col>
                <Col span={12}>
                    <Panel>
                        <div className="margin-bottom-10">
                            <Link to="/cash-book/add">
                                <Button type="info">添加</Button>
                            </Link>
                        </div>
                        <Table data={data} colunm={colunm} total={total}/>
                        <Pagination total={total} currentPage={currentPage}/>
                    </Panel>
                </Col>
            </Row>
        );
    }
}

Main.propTypes = {};

Main.defaultProps = {};

// 导出组件
export default Main;