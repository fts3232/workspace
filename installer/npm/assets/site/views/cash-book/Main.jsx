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
import Tag from '../../../components/tag';
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
            const url = getApiUrl('/api/cashBook/get');
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
            if (data.status && data.list) {
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

    render() {
        const colunm = {
            'ID': 'ROW_ID',
            '日期': 'DATE',
            '类型': 'TYPE',
            '金额': 'AMOUNT',
            '标签': (data)=>{
                const tags = data.TAGS.split(',');
                return (
                    <div>
                        {tags.map((tag)=>(
                            <Tag>{tag}</Tag>
                        ))}
                    </div>
                );
            },
            '描述': 'DESCRIPTION'
        };
        const breadcrumb = [{ 'name': '账簿', 'path': '/cash-book' }];
        const { page, data, total } = this.state;
        return (
            <Row>
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