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
import getApiUrl from '../../config/api.js';

class Main extends Component {
    constructor(props) {
        super(props);
        this.state = {
            page : parseInt(this.getParams('page', 1), 0),
            data : [],
            total: 0
        };
        this.size = 10;
        this.pageChange = this.pageChange.bind(this);
    }

    componentDidMount() {
        this.queryData();
    }

    queryData() {
        new Promise((resolve, reject) => {
            const url = getApiUrl('/api/cashBookTags/get');
            const data = { page: this.state.page, size: this.size };
            superagent.get(url)
                .query(data)
                .end((err, res) => {
                    if (typeof res !== 'undefined' && res.ok) {
                        resolve(JSON.parse(res.text));
                    } else {
                        reject(err);
                    }
                });
        }).then((data) => {
            if (data.status) {
                this.setState({ data: data.list, total: data.count });
            }
            console.log(data);
        });
    }

    pageChange(page) {
        this.setState({ 'page': page }, () => {
            this.queryData();
        });
    }

    showModal() {

    }

    render() {
        const colunm = {
            'ID': 'TAG_ID',
            '名称': 'TAG_NAME',
            '操作': (data) => (
                <div>
                    <Button type="info">修改</Button>
                    <Button type="danger" onClick={this.showModal}>删除</Button>
                </div>
            )
        };
        const breadcrumb = [{ 'name': '标签', 'path': '/cash-book-tag' }];
        const { page, data, total } = this.state;
        return (
            <Row>
                <Col span={12}>
                    <Breadcrumb data={breadcrumb}/>
                </Col>
                <Col span={12}>
                    <Panel>
                        <div className="margin-bottom-10">
                            <Link to="/cash-book-tag/add">
                                <Button type="info">添加</Button>
                            </Link>
                        </div>
                        <Table data={data} colunm={colunm} total={total}/>
                        <Pagination total={total} currentPage={page} size={this.size} onChange={this.pageChange}/>
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