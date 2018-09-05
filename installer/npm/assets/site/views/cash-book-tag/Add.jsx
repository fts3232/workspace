import React from 'react';
import { Link } from 'react-router-dom';
import superagent from 'superagent';
import Component from '../../../components/component';
import Breadcrumb from '../../../components/breadcrumb';
import Panel from '../../../components/panel';
import Button from '../../../components/button';
import { Form, Input, Select, Textarea, FormItem } from '../../../components/form';
import DatePicker from '../../../components/date-picker';
import { Col, Row } from '../../../components/grid';
import Message from '../../../components/message';
import getApiUrl from '../../config/api.js';

class Add extends Component {
    constructor(props) {
        super(props);
        this.onSubmit = this.onSubmit.bind(this);
        this.state = {
            tag: {}
        };
    }

    componentDidMount() {
        this.setState({ 'tag': { 1: '车费', 2: '饭钱', 3: '游戏', 4: '魔兽世界' } });
    }

    onSubmit(formData) {
        console.log(formData);
        new Promise((resolve, reject) => {
            const url = getApiUrl('/api/cashBookTags/add');
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
                Message.success('添加成功', 3000);
            } else {
                Message.error('添加失败', 3000);
            }
            console.log(data);
        });
    }

    render() {
        const breadcrumb = [{ 'name': '标签', 'path': '/cash-book-tag' }, { 'name': '添加', 'path': '/cash-book-tag/add' }];
        const validateRule = {
            'name': 'required'
        };
        const validateMsg = {
            'name': {
                'required': '日期不能为空'
            }
        };
        const { tag } = this.state;
        return (
            <div>
                <Row>
                    <Col span={12}>
                        <Breadcrumb data={breadcrumb}/>
                    </Col>
                </Row>
                <Row>
                    <Col span={12}>
                        <Panel>
                            <Form onSubmit={this.onSubmit} validateRule={validateRule} validateMsg={validateMsg}>
                                <FormItem label="名称" labelCol={{ span: 2 }} wrapperCol={{ span: 10 }}>
                                    <Input name="name" placeholder="请输入标签名称" id="form-name"/>
                                </FormItem>
                                <FormItem wrapperCol={{ span: 12 }} className="text-right">
                                    <Button type="info">添加</Button>
                                    <Link to="/cash-book-tag">
                                        <Button>返回</Button>
                                    </Link>
                                </FormItem>
                            </Form>
                        </Panel>
                    </Col>
                </Row>
            </div>
        );
    }
}

Add.propTypes = {};

Add.defaultProps = {};

// 导出组件
export default Add;