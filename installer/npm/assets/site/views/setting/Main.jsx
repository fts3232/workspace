import React from 'react';
import Component from '../../../components/component';
import Breadcrumb from '../../../components/breadcrumb';
import Button from '../../../components/button';
import { Col, Row } from '../../../components/grid';
import Message from '../../../components/message';

const request = require('superagent');

class Setting extends Component {
    createDB(type) {
        new Promise((resolve, reject) => {
            const url = 'http://localhost:8000/api/createDB';
            const data = { type };
            request.get(url)
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
                Message.success('创建成功', 3000);
            } else {
                Message.error('创建失败', 3000);
            }
            console.log(data);
        });
    }

    render() {
        const breadcrumb = [{ 'name': '设置', 'path': '/setting' }];
        return (
            <div className="setting-page">
                <Row>
                    <Col span={12}>
                        <Breadcrumb data={breadcrumb}/>
                    </Col>
                </Row>
                <Row>
                    <Col span={12}>
                        <h3>JavBus</h3>
                        <Button
                            type='info'
                            onClick={() => {
                                this.createDB('javbus');
                            }}
                        >创建数据库
                        </Button>
                    </Col>
                </Row>
                <Row>
                    <Col span={12}>
                        <h3>账簿</h3>
                        <Button
                            type='info'
                            onClick={() => {
                                this.createDB('cashbook');
                            }}
                        >创建数据库
                        </Button>
                    </Col>
                </Row>
            </div>
        );
    }
}

Setting.propTypes = {};

Setting.defaultProps = {};

// 导出组件
export default Setting;