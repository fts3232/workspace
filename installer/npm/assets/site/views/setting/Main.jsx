import React from 'react';
import superagent from 'superagent';
import Component from '../../../components/component';
import Breadcrumb from '../../../components/breadcrumb';
import Button from '../../../components/button';
import { Col, Row } from '../../../components/grid';
import Message from '../../../components/message';
import getApiUrl from '../../config/api.js';
import { Form, Input, FormItem } from '../../../components/form';
import Panel from '../../../components/panel';

class Setting extends Component {
    onSubmit(formData) {
        console.log(formData);
        new Promise((resolve, reject) => {
            const url = getApiUrl('/api/av/setting/url');
            superagent.post(url)
                .type('form')
                .send(formData)
                .end((err, res) => {
                    if (typeof res !== 'undefined' && res.ok) {
                        resolve(JSON.parse(res.text));
                    } else {
                        reject(err);
                    }
                });
        }).then((data) => {
            if (data.status) {
                Message.success('设置成功', 3000);
            } else {
                Message.error('设置失败', 3000);
            }
            console.log(data);
        });
    }

    createDB(type) {
        new Promise((resolve, reject) => {
            const url = getApiUrl('/api/setting/createDB');
            const data = { type };
            superagent.post(url)
                .type('form')
                .send(data)
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
        const validateRule = {
            'url': 'required'
        };
        const validateMsg = {
            'url': {
                'required': '地址不能为空'
            }
        };
        return (
            <div className="setting-page">
                <Row>
                    <Col span={12}>
                        <Breadcrumb data={breadcrumb}/>
                    </Col>
                </Row>
                <Row>
                    <Col span={12}>
                        <Panel>
                            <h3>JavBus</h3>
                            <Form onSubmit={this.onSubmit} validateRule={validateRule} validateMsg={validateMsg}>
                                <FormItem label="地址" labelCol={{ span: 1 }} wrapperCol={{ span: 11 }}>
                                    <Input name="url" placeholder="请爬取的地址" id="form-url"/>
                                </FormItem>
                                <FormItem wrapperCol={{ span: 12 }} className="text-right">
                                    <Button type="info">设置</Button>
                                    <Button
                                        type='info'
                                        onClick={() => {
                                            this.createDB('javBus');
                                        }}
                                    >
                                        创建数据库
                                    </Button>
                                </FormItem>
                            </Form>
                        </Panel>
                    </Col>
                </Row>
                <Row>
                    <Col span={12}>
                        <Panel>
                            <h3>账簿</h3>
                            <Button
                                type='info'
                                onClick={() => {
                                    this.createDB('cashBook');
                                }}
                            >创建数据库
                            </Button>
                        </Panel>
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