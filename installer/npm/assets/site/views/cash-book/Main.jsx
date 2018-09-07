import React from 'react';
import { Link } from 'react-router-dom';
import superagent from 'superagent';
import Component from '../../../components/component';
import Table from '../../../components/table';
import Breadcrumb from '../../../components/breadcrumb';
import Panel from '../../../components/panel';
import Button from '../../../components/button';
import { Col, Row } from '../../../components/grid';
import Tag from '../../../components/tag';
import getApiUrl from '../../config/api.js';

class Main extends Component {
    constructor(props) {
        super(props);
    }

    render() {
        const colunm = {
            'ID': 'ROW_ID',
            '日期': 'DATE',
            '类型': 'TYPE',
            '金额': 'AMOUNT',
            '标签': (data)=>{
                const tags = data.TAGS !== null ? data.TAGS.split(',') : [];
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
                        <Table dataSource={getApiUrl('/api/cashBook/get')} colunm={colunm}/>
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